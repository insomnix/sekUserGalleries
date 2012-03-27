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
 
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$snippets = array();
 
$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'album.items.combolist',
    'description' => 'Make a list of combo box items to display images from the selected album.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.album.items.combolist.php'),
),'',true,true);
 
$snippets[2]= $modx->newObject('modSnippet');
$snippets[2]->fromArray(array(
    'id' => 2,
    'name' => 'album.items.helper',
    'description' => 'Load helper controller for album items, process requests from the album items manager.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.album.items.helper.php'),
),'',true,true);
 
$snippets[3]= $modx->newObject('modSnippet');
$snippets[3]->fromArray(array(
    'id' => 3,
    'name' => 'album.items.manage',
    'description' => 'Load controller for album items manager, upload, update, delete.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.album.items.manage.php'),
),'',true,true);
 
$snippets[4]= $modx->newObject('modSnippet');
$snippets[4]->fromArray(array(
    'id' => 4,
    'name' => 'album.manage',
    'description' => 'Load controller for album manager, create, update, delete.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.album.manage.php'),
),'',true,true);
 
$snippets[5]= $modx->newObject('modSnippet');
$snippets[5]->fromArray(array(
    'id' => 5,
    'name' => 'album.view',
    'description' => 'Load controller to view album items.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.album.view.php'),
),'',true,true);
 
$snippets[6]= $modx->newObject('modSnippet');
$snippets[6]->fromArray(array(
    'id' => 6,
    'name' => 'browse.galleries',
    'description' => 'Load controller to browse all user galleries.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.browse.galleries.php'),
),'',true,true);
 
$snippets[7]= $modx->newObject('modSnippet');
$snippets[7]->fromArray(array(
    'id' => 7,
    'name' => 'directory',
    'description' => 'Load controller to view directory space.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.directory.php'),
),'',true,true);
 
$snippets[8]= $modx->newObject('modSnippet');
$snippets[8]->fromArray(array(
    'id' => 8,
    'name' => 'image.information',
    'description' => 'View image information, camera used, date/time, etc.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.image.information.php'),
),'',true,true);
 
$snippets[9]= $modx->newObject('modSnippet');
$snippets[9]->fromArray(array(
    'id' => 9,
    'name' => 'navigation',
    'description' => 'View navigation information.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.navigation.php'),
),'',true,true);
 
$snippets[10]= $modx->newObject('modSnippet');
$snippets[10]->fromArray(array(
    'id' => 10,
    'name' => 'search',
    'description' => 'Load controller for album search and display.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.search.php'),
),'',true,true);
 
$snippets[11]= $modx->newObject('modSnippet');
$snippets[11]->fromArray(array(
    'id' => 11,
    'name' => 'users.gallery.manage',
    'description' => 'Load controller for user gallery management.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.users.gallery.manage.php'),
),'',true,true);
 
$snippets[12]= $modx->newObject('modSnippet');
$snippets[12]->fromArray(array(
    'id' => 12,
    'name' => 'users.gallery.view',
    'description' => 'Load controller for gallery viewer.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.users.gallery.view.php'),
),'',true,true);

return $snippets;