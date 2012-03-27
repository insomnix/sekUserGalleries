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

$value = $modx->getOption('value',$scriptProperties,'');

$modx->regClientCSS($sekug->config['cssUrl'].'web/dd.css');
$modx->regClientScript($sekug->config['jsUrl'].'web/jquery.dd.js');
$src = '<script language="javascript" type="text/javascript">
            function showvalue(arg) {
                alert(arg);
            }
            $(document).ready(function() {
                try {
                    oHandler = $(".mydds").msDropDown().data("dd");
                    $("#ver").html($.msDropDown.version);
                } catch(e) {
                    alert("Error: "+e.message);
                }
            })
        </script>';
$modx->regClientScript($src);
$items = $modx->getCollection('sekugAlbumItems',array(
    'album_id' => $_REQUEST['album']
));
$baseAlbumUrl = $sekug->config['displayGalleryUrl'] . $modx->user->get('id') . '/' . $_REQUEST['album'] . '/';
$itemComboList = '<option value="" title="">'.$modx->lexicon('sekug.random_image').'</option>';
foreach ($items as $item) {
    $itemArray = $item->toArray();
    $itemArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $itemArray['file_name'] . '.' .$itemArray['file_ext_resize'];
    $selected = ($itemArray['id']==$value)?' selected="selected"':'';
    $itemComboList .= '<option value="'.$itemArray['id'].'" title="'.$itemArray['thumbnail_image'].'"'.$selected.'>'.$itemArray['item_title'].'</option>';
}
return $itemComboList;