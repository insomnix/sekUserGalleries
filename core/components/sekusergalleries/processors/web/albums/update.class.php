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

class sekugAlbumsUpdateProcessor extends sekugProcessor {
    /** @var $album */
    public $album;

    /**
     * @return boolean|string
     */
    public function process() {
        $this->album = $this->modx->getObject('sekugAlbums',$this->dictionary->get('album_id'));
        $this->setAlbumFields();

        if (!$this->album->save()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not update album by user: '.$this->modx->user->get('username').' album '.$this->getProperty('album'));
            return $this->modx->lexicon('sekug.album_err_save');
        }
        return true;
    }

    /**
     * Setup the album
     *
     * @return void
     */
    public function setAlbumFields() {
        $fields = $this->dictionary->toArray();
        /* set album */
        $this->album->fromArray($fields);
    }
}
return 'sekugAlbumsUpdateProcessor';