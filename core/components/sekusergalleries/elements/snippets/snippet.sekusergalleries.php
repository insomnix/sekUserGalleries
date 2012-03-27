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

$output = '';
/* create tables */
$m = $modx->getManager();

$created = $m->createObjectContainer('sekugGroupSettings');
$output .= $created ? 'sekugGroupSettings Table created.<br />' : 'sekugGroupSettings Table not created.<br />';

$created = $m->createObjectContainer('sekugUserSettings');
$output .= $created ? 'sekugUserSettings Table created.<br />' : 'sekugUserSettings Table not created.<br />';

$created = $m->createObjectContainer('sekugAlbums');
$output .= $created ? 'sekugAlbums Table created.<br />' : 'sekugAlbums Table not created.<br />';

$created = $m->createObjectContainer('sekugAlbumItems');
$output .= $created ? 'sekugAlbumItems Table created.<br />' : 'sekugAlbumItems Table not created.<br />';

$created = $m->createObjectContainer('sekugImageSizes');
$output .= $created ? 'sekugImageSizes Table created.<br />' : 'sekugImageSizes Table not created.<br />';

$created = $m->createObjectContainer('sekugMimeTypes');
$output .= $created ? 'sekugMimeTypes Table created.<br />' : 'sekugMimeTypes Table not created.<br />';

$created = $m->createObjectContainer('sekugReportAbuse');
$output .= $created ? 'sekugReportAbuse Table created.<br />' : 'sekugReportAbuse Table not created.<br />';

return $output;
