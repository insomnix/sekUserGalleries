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

$tplContainer = $modx->getOption('tplContainer',$scriptProperties,'favorites.view');
$tplItem = $modx->getOption('tplItem',$scriptProperties,'album.items.list');
$tplAltImages = $modx->getOption('tplAltImages',$scriptProperties,'album.items.alt');
$customcss = $modx->getOption('customcss',$scriptProperties,'');

$cssUrl = $sekug->config['cssUrl'].'web/';
if($customcss>''){
    $modx->regClientCSS($modx->getOption('assets_url').$customcss);
} else {
    $modx->regClientCSS($cssUrl.'gallery.structure.css');
}

$user_id = $modx->user->get('id');
$favoriteItems = '';
$favorites['item_list'] = '';

$image_sizes = $modx->getCollection('sekugImageSizes');
foreach ($image_sizes as $image_size) {
    $sizeArray = $image_size->toArray();
    $images[$sizeArray['name']] = array(
        'name' => $sizeArray['name'],
        'description' => $sizeArray['description'],
        'max_width' => $sizeArray['max_width'],
        'max_height' => $sizeArray['max_height'],
        'image_quality' => $sizeArray['image_quality'],
        'primary' => $sizeArray['primary']
    );
}

if($user_id > 0){
    $sekug_favorite = $modx->getCollectionGraph('sekugFavorites', '{ "sekugAlbumItems":{ "sekugAlbums":{} } }', array(
        'user_id' => $user_id
    ));

    if($sekug_favorite != null){
        foreach ($sekug_favorite as $favorite) {
            $itemArray['item_title'] = $favorite->sekugAlbumItems->get('item_title');
            $itemArray['file_name'] = $favorite->sekugAlbumItems->get('file_name');

            $baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $favorite->sekugAlbumItems->sekugAlbums->get('album_user') . '/' . $favorite->sekugAlbumItems->sekugAlbums->get('id') . '/';

            $primary_image = '';
            $alt_images = '';
            foreach ($image_sizes as $image_size) {
                $imageArray = $image_size->toArray();
                if($imageArray['primary']==1){
                    $primary_image = $baseAlbumUrl.$imageArray['name'].'/'.$favorite->sekugAlbumItems->get('file_name') . '.' .$favorite->sekugAlbumItems->get('file_ext_resize');
                }else{
                    $imageArray['image'] = $baseAlbumUrl.$imageArray['name'].'/'.$favorite->sekugAlbumItems->get('file_name') . '.' .$favorite->sekugAlbumItems->get('file_ext_resize');
                    $imageArray['item_title'] = $favorite->sekugAlbumItems->get('item_title');
                    $alt_images .= $sekug->getChunk($tplAltImages,$imageArray);
                }
            }
            //$itemArray['add_favorite_url'] = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'addToFavorites','albumItemID' => $favorite->sekugAlbumItems->get('id'))) : '';;
            $itemArray['primary_image'] = $primary_image;
            $itemArray['alt_images'] = $alt_images;
            $itemArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $favorite->sekugAlbumItems->get('file_name') . '.' .$favorite->sekugAlbumItems->get('file_ext_resize');
            $itemArray['image_info_url'] = $modx->makeUrl($modx->getOption('sekusergalleries.image_info_resource_id'),'',array('item' => $favorite->sekugAlbumItems->get('id')));

            $favoriteItems .= $sekug->getChunk($tplItem,$itemArray);
        }

    }
}elseif($_SESSION['sekug_favorites'] != null){
    $sekug_favorite = $modx->getCollectionGraph('sekugAlbumItems', '{ "sekugAlbums":{} }', array(
        'id:IN' => $_SESSION['sekug_favorites']
    ));

    if($sekug_favorite != null){
        foreach ($sekug_favorite as $favorite) {
            $itemArray['item_title'] = $favorite->get('item_title');
            $itemArray['file_name'] = $favorite->get('file_name');

            $baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $favorite->sekugAlbums->get('album_user') . '/' . $favorite->sekugAlbums->get('id') . '/';

            $primary_image = '';
            $alt_images = '';
            foreach ($image_sizes as $image_size) {
                $imageArray = $image_size->toArray();
                if($imageArray['primary']==1){
                    $primary_image = $baseAlbumUrl.$imageArray['name'].'/'.$favorite->get('file_name') . '.' .$favorite->get('file_ext_resize');
                }else{
                    $imageArray['image'] = $baseAlbumUrl.$imageArray['name'].'/'.$favorite->get('file_name') . '.' .$favorite->get('file_ext_resize');
                    $imageArray['item_title'] = $favorite->get('item_title');
                    $alt_images .= $sekug->getChunk($tplAltImages,$imageArray);
                }
            }
            //$itemArray['add_favorite_url'] = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'addToFavorites','albumItemID' => $favorite->sekugAlbumItems->get('id'))) : '';;
            $itemArray['primary_image'] = $primary_image;
            $itemArray['alt_images'] = $alt_images;
            $itemArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $favorite->get('file_name') . '.' .$favorite->get('file_ext_resize');
            $itemArray['image_info_url'] = $modx->makeUrl($modx->getOption('sekusergalleries.image_info_resource_id'),'',array('item' => $favorite->get('id')));

            $favoriteItems .= $sekug->getChunk($tplItem,$itemArray);
        }

    }
}
$favorites['item_list'] = $favoriteItems;

return $sekug->getChunk($tplContainer,$favorites);