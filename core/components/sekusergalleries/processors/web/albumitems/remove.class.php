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

class sekugAlbumItemsRemoveProcessor extends sekugProcessor {
    /** @var $album */
    public $album;

    /**
     * @return boolean|string
     */
    public function process() {
        $this->album = $this->modx->getObject('sekugAlbumItems',$_REQUEST['item']);
        if (!$this->album->remove()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not remove album item by user: '.$this->modx->user->get('username').' item '.$this->getProperty('id'));
            return $this->modx->lexicon('sekug.albumitem_err_remove');
        }
        return true;
    }

}
return 'sekugAlbumItemsRemoveProcessor';