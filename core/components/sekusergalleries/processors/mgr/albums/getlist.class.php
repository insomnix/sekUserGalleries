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

class sekugAlbumsGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sekugAlbums';
    public $languageTopics = array('sekugusergalleries:default');
    public $defaultSortField = 'album_title';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'sekug.album';

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$query = $this->getProperty('query');
		if (!empty($query)) {
			$c->where(array(
				'album_title:LIKE' => '%'.$query.'%',
				'OR:album_description:LIKE' => '%'.$query.'%',
			));
		}
		return $c;
	}

}
return 'sekugAlbumsGetListProcessor';