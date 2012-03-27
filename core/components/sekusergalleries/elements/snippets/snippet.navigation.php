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

$album_id = $modx->getOption('album_id',$scriptProperties,'');
$tplNav = $modx->getOption('tplNav',$scriptProperties,'navigation');

$nav['album_id'] = $album_id;
$nav['search_albums_url'] =  ($modx->getOption('sekusergalleries.album_search_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.album_search_resource_id')) : '';
$nav['browse_galleries_url'] = ($modx->getOption('sekusergalleries.browsegalleries_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.browsegalleries_resource_id')) : '';
$nav['my_gallery_url'] =  ($modx->getOption('sekusergalleries.usersgallery_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.usersgallery_resource_id')) : '';
$nav['edit_gallery_url'] =  ($modx->getOption('sekusergalleries.editgallery_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.editgallery_resource_id')) : '';
$nav['create_album_url'] =  ($modx->getOption('sekusergalleries.album_manage_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.album_manage_resource_id')) : '';
$nav['directory_stats_url'] =  ($modx->getOption('sekusergalleries.directory_stats_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.directory_stats_resource_id')) : '';
$nav['update_album_url'] =  ($modx->getOption('sekusergalleries.album_manage_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.album_manage_resource_id'),'',array('album' => $album_id)) : '';
$nav['delete_album_url'] =  ($modx->getOption('sekusergalleries.album_manage_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.album_manage_resource_id'),'',array('album' => $album_id,'action' => 'del')) : '';
$nav['manage_items_url'] =  ($modx->getOption('sekusergalleries.items_manage_resource_id')>'') ? $modx->makeUrl($modx->getOption('sekusergalleries.items_manage_resource_id'),'',array('album' => $album_id)) : '';

return $sekug->getChunk($tplNav,$nav);