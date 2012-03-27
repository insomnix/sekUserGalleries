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

$namespace = 'sekusergalleries';
$settings = array();

$settings['sekusergalleries.load_jquery']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.load_jquery']->fromArray(array(
    'key' => 'sekusergalleries.load_jquery',
    'value' => '1',
    'xtype' => 'modx-combo-boolean',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.browsegalleries_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.browsegalleries_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.browsegalleries_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.usersgallery_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.usersgallery_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.usersgallery_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.editgallery_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.editgallery_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.editgallery_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.album_view_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.album_view_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.album_view_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.album_manage_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.album_manage_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.album_manage_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.items_manage_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.items_manage_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.items_manage_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.items_helper_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.items_helper_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.items_helper_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.album_search_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.album_search_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.album_search_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.image_info_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.image_info_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.image_info_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.directory_stats_resource_id']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.directory_stats_resource_id']->fromArray(array(
    'key' => 'sekusergalleries.directory_stats_resource_id',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.gallerycover_thumb_max_width']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.gallerycover_thumb_max_width']->fromArray(array(
    'key' => 'sekusergalleries.gallerycover_thumb_max_width',
    'value' => '150',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.gallerycover_thumb_max_height']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.gallerycover_thumb_max_height']->fromArray(array(
    'key' => 'sekusergalleries.gallerycover_thumb_max_height',
    'value' => '150',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.gallerycover_display_max_width']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.gallerycover_display_max_width']->fromArray(array(
    'key' => 'sekusergalleries.gallerycover_display_max_width',
    'value' => '300',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.gallerycover_display_max_height']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.gallerycover_display_max_height']->fromArray(array(
    'key' => 'sekusergalleries.gallerycover_display_max_height',
    'value' => '300',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.image_thumb_max_width']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.image_thumb_max_width']->fromArray(array(
    'key' => 'sekusergalleries.image_thumb_max_width',
    'value' => '150',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.image_thumb_max_height']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.image_thumb_max_height']->fromArray(array(
    'key' => 'sekusergalleries.image_thumb_max_height',
    'value' => '150',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.max_file_size']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.max_file_size']->fromArray(array(
    'key' => 'sekusergalleries.max_file_size',
    'value' => '5242880',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.min_file_size']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.min_file_size']->fromArray(array(
    'key' => 'sekusergalleries.min_file_size',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.orient_image']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.orient_image']->fromArray(array(
    'key' => 'sekusergalleries.orient_image',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

$settings['sekusergalleries.discard_aborted_uploads']= $modx->newObject('modSystemSetting');
$settings['sekusergalleries.discard_aborted_uploads']->fromArray(array(
    'key' => 'sekusergalleries.discard_aborted_uploads',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => $namespace,
    'area' => '',
),'',true,true);

return $settings;