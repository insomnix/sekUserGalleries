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

class sekugWatermarkComboListProcessor extends modProcessor {
    public $watermark_path;
    public $languageTopics = array('sekusergalleries:default');

    public function initialize() {
        $this->watermark_path = $this->modx->sekug->config['storeGalleryPath'].'watermarks/';
        return true;
    }

    public function process() {
        if (!$this->modx->loadClass('sekugDirectory',$this->modx->sekug->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load sekugDirectory class.');
            return false;
        }
        $this->directory = new sekugDirectory($this->modx->sekug);
        $images = $this->directory->get_directory_content($this->watermark_path);

        $results = array();
        $total = 0;
        if($images){
            foreach($images as $image) {
                $results[] = array(
                    'image' => $image,
                );
                $total++;
            }
        }
        $returnArray = array(
            'success' => true,
            'total' => $total,
            'results' => $results
        );
        return $this->modx->toJSON($returnArray);
    }
}
return 'sekugWatermarkComboListProcessor';

