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
 
$chunks = array();

$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'album.delete',
    'description' => 'Delete album form.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.delete.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'album.form',
    'description' => 'Create/Edit album form.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.form.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'album.items.alt',
    'description' => 'Retrieve alternate image version size links.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.items.alt.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'album.items.form',
    'description' => 'Album items form, upload, update, delete.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.items.form.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[5]= $modx->newObject('modChunk');
$chunks[5]->fromArray(array(
    'id' => 5,
    'name' => 'album.items.js.display',
    'description' => 'Album items javascript display tile.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.items.js.display.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[6]= $modx->newObject('modChunk');
$chunks[6]->fromArray(array(
    'id' => 6,
    'name' => 'album.items.js.upload',
    'description' => 'Album items javascript upload tile.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.items.js.upload.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[7]= $modx->newObject('modChunk');
$chunks[7]->fromArray(array(
    'id' => 7,
    'name' => 'album.items.list',
    'description' => 'Album items list for album view.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.items.list.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[8]= $modx->newObject('modChunk');
$chunks[8]->fromArray(array(
    'id' => 8,
    'name' => 'album.password.form',
    'description' => 'Album password form.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.password.form.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[9]= $modx->newObject('modChunk');
$chunks[9]->fromArray(array(
    'id' => 9,
    'name' => 'album.view',
    'description' => 'Album view container.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/album.view.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[10]= $modx->newObject('modChunk');
$chunks[10]->fromArray(array(
    'id' => 10,
    'name' => 'browse.galleries.container',
    'description' => 'Browse users galleries container.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/browse.galleries.container.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[11]= $modx->newObject('modChunk');
$chunks[11]->fromArray(array(
    'id' => 11,
    'name' => 'browse.galleries.row',
    'description' => 'Browse user galleries row.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/browse.galleries.row.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[12]= $modx->newObject('modChunk');
$chunks[12]->fromArray(array(
    'id' => 12,
    'name' => 'directory.bargraph',
    'description' => 'Directory bargraph.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/directory.bargraph.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[13]= $modx->newObject('modChunk');
$chunks[13]->fromArray(array(
    'id' => 13,
    'name' => 'directory.container',
    'description' => 'Directory container.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/directory.container.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[14]= $modx->newObject('modChunk');
$chunks[14]->fromArray(array(
    'id' => 14,
    'name' => 'image.information',
    'description' => 'Display image information.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/image.information.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[15]= $modx->newObject('modChunk');
$chunks[15]->fromArray(array(
    'id' => 15,
    'name' => 'navigation',
    'description' => 'Navigation menu.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/navigation.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[16]= $modx->newObject('modChunk');
$chunks[16]->fromArray(array(
    'id' => 16,
    'name' => 'search.container',
    'description' => 'Search albums container.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/search.container.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[17]= $modx->newObject('modChunk');
$chunks[17]->fromArray(array(
    'id' => 17,
    'name' => 'users.gallery.albumlist',
    'description' => 'Display users gallery albums for gallery view.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/users.gallery.albumlist.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[18]= $modx->newObject('modChunk');
$chunks[18]->fromArray(array(
    'id' => 18,
    'name' => 'users.gallery.form',
    'description' => 'Users gallery form, update gallery image information.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/users.gallery.form.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[19]= $modx->newObject('modChunk');
$chunks[19]->fromArray(array(
    'id' => 19,
    'name' => 'users.gallery.view',
    'description' => 'View gallery.',
    'snippet' => file_get_contents($sources['elements'].'/chunks/users.gallery.view.chunk.tpl'),
    'properties' => '',
),'',true,true);

return $chunks;
