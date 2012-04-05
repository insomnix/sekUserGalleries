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

class sekugWatermarkUploadProcessor extends modProcessor {
    public $imagehandler;
    public $watermark_path;
    public $thumb_path;
    public $thumb_url;
    public $languageTopics = array('sekusergalleries:default');

    public function initialize() {
        $this->watermark_path = $this->modx->sekug->config['storeGalleryPath'].'watermarks/';
        $this->thumb_path = $this->modx->sekug->config['displayGalleryPath'].'watermarks/';
        $this->thumb_url = $this->modx->sekug->config['displayGalleryUrl'].'watermarks/';
        return true;
    }

    public function upload_image(){
        $imgconfig = array(
            'param_name' => 'files',
            'accept_mime_types' => array(
                'image/jpeg' => 'jpg',
                'image/png' => 'png'
            ),
            'upload_dir' => $this->watermark_path,
            'image_versions' => array(
                'thumb' => array(
                    'upload_dir' => $this->thumb_path,
                    'upload_url' => $this->thumb_url,
                    'name' => 'thumb',
                    'max_width' => 150,
                    'max_height' => 150,
                    'image_quality' => 90
                )
            )
        );

        if (!$this->modx->loadClass('sekugImageHandler',$this->modx->sekug->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load sekugImageHandler class from ');
            return false;
        }
        $this->imagehandler = new sekugImageHandler($this->modx->sekug,$imgconfig);
        $upload = isset($_FILES['file']) ? $_FILES['file'] : null;
        $info = array();

        if ($upload) {
            $this->imagehandler->handle_file_upload(
               isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
               isset($upload['name']) ? $upload['name'] : null,
               isset($upload['size']) ? $upload['size'] : null,
               isset($upload['type']) ? $upload['type'] : null,
               isset($upload['error']) ? $upload['error'] : null
            );
            return $info[0]->resize_name;
        }
        return false;
    }

    public function process() {
        header('Content-type: application/json');
        $this->upload_image();
        return json_encode(true);
    }
}
return 'sekugWatermarkUploadProcessor';