<?php
/**
 * User Galleries
 *
 * Copyright 2012 by Stephen Smith <ssmith@seknetsolutions.com>
 *
 * sekUserGalleries is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * sekUserGalleries is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * sekUserGalleries; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package sekusergalleries
 */
$sekug = $modx->getService('sekusergalleries','sekUserGalleries',$modx->getOption('sekusergalleries.core_path',null,$modx->getOption('core_path').'components/sekusergalleries/').'model/sekusergalleries/',$scriptProperties);
if (!($sekug instanceof sekUserGalleries)) return '';

$tplContainer = $modx->getOption('tplContainer',$scriptProperties,'favorites.panel.container');
$tplRow = $modx->getOption('tplRow',$scriptProperties,'favorites.panel.row');
$customcss = $modx->getOption('customcss',$scriptProperties,'');
$loadjquery = $modx->getOption('loadjquery',$scriptProperties,$modx->getOption('sekusergalleries.load_jquery'));

$favorites_helper_url = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id')) : '';

$cssUrl = $sekug->config['cssUrl'].'web/';
$jsUrl = $sekug->config['jsUrl'].'web/';
if($loadjquery == 1){
    $modx->regClientStartupScript($jsUrl.'libs/'.$sekug->config['jqueryFile']);
}

$js='<script type="text/javascript">
    var helper_url = "'.$favorites_helper_url.'";
    var image_loader_url = "'.$sekug->config['imagesUrl'].'loader.gif";
</script>';
$modx->regClientStartupScript($js);

$modx->regClientScript($jsUrl.'favorites.js');
if($customcss>''){
    $modx->regClientCSS($modx->getOption('assets_url').$customcss);
} else {
    $modx->regClientCSS($cssUrl.'favorites.css');
}

$user_id = $modx->user->get('id');
$favoriteItems = '';
$favorites['items'] = '';
if($user_id > 0){
    $sekug_favorite = $modx->getCollectionGraph('sekugFavorites', '{ "sekugAlbumItems":{ "sekugAlbums":{} } }', array(
        'user_id' => $user_id
    ));
    if($sekug_favorite != null){
        foreach ($sekug_favorite as $favorite) {
            $favoriteArray = $favorite->toArray();
            $baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $favorite->sekugAlbumItems->sekugAlbums->get('album_user') . '/' . $favorite->sekugAlbumItems->get('album_id') . '/';

            $favoriteArray['item_title'] = $favorite->sekugAlbumItems->get('item_title');
            $favoriteArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $favorite->sekugAlbumItems->get('file_name') . '.' .$favorite->sekugAlbumItems->get('file_ext_resize');
            $favoriteArray['file_name'] = $favorite->sekugAlbumItems->get('file_name');
            $favoriteArray['remove_fav_img'] = $sekug->config['imagesUrl'].'delete.png';
            $favoriteArray['remove_favorite_url'] = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'removeFromFavorites','albumItemID' => $favorite->sekugAlbumItems->get('id'))) : '';
            $favoriteItems .= $sekug->getChunk($tplRow,$favoriteArray);
        }
        $favorites['items'] = $favoriteItems;
    }
}
if($_SESSION['sekug_favorites'] != null){
    foreach ($_SESSION['sekug_favorites'] as $favorite) {
        $favoriteArray['item_id'] = $favorite;

        $albumItem = $modx->getObject('sekugAlbumItems',$favorite);
        if($albumItem){
            $album = $modx->getObject('sekugAlbums',$albumItem->get('album_id'));
            $baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $album->get('album_user') . '/' . $albumItem->get('album_id') . '/';
            $favoriteArray['item_title'] = $albumItem->get('item_title');
            $favoriteArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $albumItem->get('file_name') . '.' .$albumItem->get('file_ext_resize');
            $favoriteArray['file_name'] = $albumItem->get('file_name');
            $favoriteArray['remove_fav_img'] = $sekug->config['imagesUrl'].'delete.png';
            $favoriteArray['remove_favorite_url'] = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'removeFromFavorites','albumItemID' => $albumItem->get('id'))) : '';

            $favoriteItems .= $sekug->getChunk($tplRow,$favoriteArray);
        }else{
            unset($_SESSION['sekug_favorites'][$favorite]);
        }
    }
    $favorites['items'] = $favoriteItems;
}

return $sekug->getChunk($tplContainer,$favorites);