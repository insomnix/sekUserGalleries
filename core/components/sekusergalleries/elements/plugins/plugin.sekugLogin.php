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

$user_id = $user->id;
if($_SESSION['sekug_favorites'] != null){
    foreach ($_SESSION['sekug_favorites'] as $favorite) {
        $item_id = $favorite;
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
    }
}
unset($_SESSION['sekug_favorites']);