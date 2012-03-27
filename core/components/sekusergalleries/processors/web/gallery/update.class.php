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

class sekugGalleryUpdateProcessor extends sekugProcessor {
    /** @var $gallery */
    public $gallery;

    /**
     * @return boolean|string
     */
    public function process() {
        $this->gallery = $this->modx->getObject('sekugUserSettings',$this->modx->user->get('id'));
        $this->setGalleryFields();

        if (!$this->gallery->save()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not save new gallery by user: '.$this->modx->user->get('username'));
            return $this->modx->lexicon('sekug.gallery_err_save');
        }
        return true;
    }

    /**
     * Update the gallery
     *
     * @return void
     */
    public function setGalleryFields() {
        $fields = $this->dictionary->toArray();
        $this->gallery->fromArray($fields);
    }

}
return 'sekugGalleryUpdateProcessor';