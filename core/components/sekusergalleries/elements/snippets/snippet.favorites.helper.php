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

$tplRow = $modx->getOption('tplRow',$scriptProperties,'favorites.panel.row');

$action = $_POST['action'];
$item_id = $_POST['albumItemID'];
$user_id = $modx->user->get('id');

if ($action == "addToFavorites"){
    $favoriteItems = '';
    // if user is logged in, add to table
    if($user_id > 0){
        // check user id and item id combination already exists in table
        $checkExists = $modx->getObject('sekugFavorites', array(
            'user_id' => $user_id,
            'item_id' => $item_id
        ));
        // if it doesn't exist, add to the table
        if($checkExists==null){
            $sekug_new_favorite = $modx->newObject('sekugFavorites',array(
                'user_id' => $user_id,
                'item_id' => $item_id
            ));
            $sekug_new_favorite->save();
        }
    } else {
        // use session to store favorites
        $addItem = true;
        // check if item id exists in session
        if(isset($_SESSION['sekug_favorites'])) {
            foreach ($_SESSION['sekug_favorites'] as $favorite) {
                if($item_id == $favorite) {$addItem = false;}
            }
        }
        if($addItem) {$_SESSION['sekug_favorites'][$item_id] = $item_id;}
    }

    // get the file name and item title to display
    $albumItem = $modx->getObject('sekugAlbumItems',$item_id);
    $album = $modx->getObject('sekugAlbums',$albumItem->get('album_id'));

    $baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $album->get('album_user') . '/' . $albumItem->get('album_id') . '/';

    $favoriteArray['item_id'] = $item_id;
    $favoriteArray['item_title'] = $albumItem->get('item_title');
    $favoriteArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $albumItem->get('file_name') . '.' .$albumItem->get('file_ext_resize');
    $favoriteArray['file_name'] = $albumItem->get('file_name');
    $favoriteArray['remove_fav_img'] = $sekug->config['imagesUrl'].'delete.png';
    $favoriteArray['remove_favorite_url'] = ($modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'removeFromFavorites','albumItemID' => $albumItem->get('id'))) : '';

    // return the item to display in the favorite panel
    $favoriteItems .= $sekug->getChunk($tplRow,$favoriteArray);

    return $favoriteItems;
} elseif ($action == "removeFromFavorites") {
    if($user_id > 0){
        $deleteItem = $modx->getObject('sekugFavorites', array(
            'user_id' => $user_id,
            'item_id' => $item_id
        ));
        if($deleteItem!=null){
             $deleteItem->remove();
        }
    }else{
        unset($_SESSION['sekug_favorites'][$item_id]);
    }
    return true;
}
return false;
