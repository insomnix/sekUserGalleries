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

$item = $_REQUEST['item'];
$tplContainer = $modx->getOption('tplContainer',$scriptProperties,'image.information');

$sekug_album_item = $modx->getObject('sekugAlbumItems',array(
    'id' => $item
));
$sekug_album = $modx->getObject('sekugAlbums',array(
    'id' => $sekug_album_item->get('album_id')
));
$storeAlbumPath = $sekug->config['storeGalleryPath'] . $sekug_album->get('album_user') . '/' . $sekug_album_item->get('album_id') . '/';
$image_path  = $storeAlbumPath . 'alpha/' . $sekug_album_item->get('file_name') . '.' .$sekug_album_item->get('file_ext');

$return = $sekug->getImageInformation($image_path);

return $sekug->getChunk($tplContainer,$return);
