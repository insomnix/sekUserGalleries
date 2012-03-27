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

class sekugImageSizesCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sekugImageSizes';
    public $languageTopics = array('sekusergalleries:default');
    public $objectType = 'sekug.imagesizes';

    public function beforeSet() {
        $this->setProperty('name',preg_replace("/[^A-Za-z0-9]/","",$this->getProperty('name')));
        //$this->setProperty('watermark_location',($this->getProperty('watermark_location') > '') ? $this->getProperty('watermark_location') : 'Center');
        return parent::beforeSet();
    }

    public function beforeSave() {
        $name = $this->getProperty('name');
        $max_width = $this->getProperty('max_width');
        $max_height = $this->getProperty('max_height');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('sekug.name.err.ns'));
        }
		else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('sekug.name.err.ae'));
        }
        if (empty($max_width)) {
            $this->addFieldError('max_width',$this->modx->lexicon('sekug.max_width.err.ns'));
        }
        if (empty($max_height)) {
            $this->addFieldError('max_height',$this->modx->lexicon('sekug.max_height.err.ns'));
        }

		return parent::beforeSave();
    }
}
return 'sekugImageSizesCreateProcessor';