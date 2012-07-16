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

class sekugAlbumItemsCreateProcessor extends sekugProcessor {
    /** @var $albumitem */
    public $albumitem;

    /**
     * @return boolean|string
     */
    public function process() {
        $this->albumitem = $this->modx->newObject('sekugAlbumItems');
        $this->setAlbumItemFields();
        if (!$this->albumitem->save()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not save new album item by user: '.$this->modx->user->get('username'));
            return $this->modx->lexicon('sekug.album_err_save');
        }
        $this->controller->setProperty('albumitem',$this->albumitem->get('id'));
        return true;
    }

    /**
     * Setup the albumitem
     *
     * @return void
     */
    public function setAlbumItemFields() {
        $fields = $this->dictionary->toArray();
        /* set albumitem */
        $this->albumitem->fromArray($fields);
        $fields = $this->dictionary->toArray();
        $newExtended = array();
        foreach ($fields as $field => $value) {
            $isValidExtended = true;
            if ( empty($value) || $field == 'files' || $field == 'id' || $field == 'item_title' || $field == 'item_description' || $field == 'file_name' || $field == 'file_ext' || $field == 'file_ext_resize' || $field == 'file_datetime' || $field == 'album_id') {
                $isValidExtended = false;
            }

            if ($isValidExtended) {
                $newExtended[$field] = $value;
            }
        }
        /* set albumitem */
        $this->albumitem->fromArray($fields);

        $this->albumitem->set('extended',$newExtended);
    }
}
return 'sekugAlbumItemsCreateProcessor';