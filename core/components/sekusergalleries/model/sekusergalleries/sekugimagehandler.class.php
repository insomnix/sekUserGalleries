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

/**
 * Handle upload, retrieval, and removal of files.
 *
 * @package sekusergalleries
 */
class sekugImageHandler {
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;
    /**
     * A reference to the sekUserGalleries instance
     * @var sekUserGalleries $sekug
     */
    public $sekug;
    /**
     * A configuration array
     * @var array $config
     */
    public $config = array();

    /**
     * Construct class
     * @param sekUserGalleries $sekug
     * @param array $config
     */
    function __construct(sekUserGalleries &$sekug, array $config = array()) {
        $this->sekug =& $sekug;
        $this->modx =& $sekug->modx;

        // set up upload file options
        $this->config = array(
            'script_url' => '',
            'upload_dir' => '',
            'upload_url' => '',
            'param_name' => 'files',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            'accept_mime_types' => '',
            // Set the following option to false to enable non-multipart uploads:
            'discard_aborted_uploads' => true,
            // Set to true to rotate images based on EXIF meta data, if available:
            'orient_image' => false,
            'image_versions' => '',
        );
        //add config data from class to the default config data
        $this->config = array_merge($this->config,$config);
        // create folder structure if it doesn't already exist for primary image
        if (!is_dir( $this->config['upload_dir'] )){
            mkdir($this->config['upload_dir'], 0777, true);
        }
        // create folder structure if it doesn't already exist for version images
        foreach($this->config['image_versions'] as $version => $options) {
            if (!is_dir( $options['upload_dir'] )){
                mkdir($options['upload_dir'], 0777, true);
            }
        }
    }

/*    public function get_mime_type($filename){
        $imginfo_array = getimagesize($filename);
        $mime = '';
        if ($imginfo_array !== false) {
            $mime = $imginfo_array['mime'];
        }
        return $mime;
    }*/

    public function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.'.$matches[1];
        }
        return $file_name;
    }

    public function update_scaled_images($filename){
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $type = finfo_file($finfo, $this->config['upload_dir'].$filename);
        finfo_close($finfo);

        $resize_ext = $this->config['accept_mime_types'][$type];
        $resize_filename = pathinfo($filename,PATHINFO_FILENAME).'.'.$resize_ext;

        foreach($this->config['image_versions'] as $version => $options) {
            $this->create_scaled_image($filename, $resize_filename, $options);
        }
    }

    /**
     * Create display images
     * @param string $file_name
     * @param array $options
     * @return void
     */
    private function create_scaled_image($file_name, $new_file_name, $options) {
        // alpha image
        $file_path = $this->config['upload_dir'].$file_name;
        // resize image
        $new_file_path = $options['upload_dir'].$new_file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale > 1) {
            $scale = 1;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;

        $imagick_path = exec("type convert");
        if (extension_loaded('imagick') || $imagick_path > '') {
            $command = "convert $file_path -resize {$new_width}x{$new_height} ".
                "-colorspace RGB -strip -quality ".$options['image_quality']." $new_file_path";
            exec($command);

            // if there is a value in the watermark image field create watermark
            if($options['watermark_image']>''){
                if(file_exists($options['watermark_image'])){
                    $command = " -watermark ".$options['watermark_brightness'].
                        " -gravity ".$options['watermark_location'].
                        " ".$options['watermark_image'].
                        " $new_file_path";
                    exec("composite $command $new_file_path");
                }else{
                    $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] watermark image does not exist at '.$options['watermark_image']);
                }
            }
            // if there is a value in watermark text, create text watermark
            elseif($options['watermark_text']>''){
                $command = "convert $new_file_path ".
                    " -pointsize ".$options['watermark_font_size'].
                    " -font ".$options['watermark_font'].
                    " -fill rgba(".$options['watermark_text_color'].",". $options['watermark_brightness']/100 .")".
                    " -gravity ".$options['watermark_location'].
                    " -annotate +0+0".
                    " ".$options['watermark_text'].
                    " $new_file_path ";
                // $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] '. $command);
                exec($command);
            }
            return true;
        } elseif (extension_loaded('gd') && function_exists('gd_info')) {
            $new_img = @imagecreatetruecolor($new_width, $new_height);
            switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
                case 'jpg':
                case 'jpeg':
                    $src_img = @imagecreatefromjpeg($file_path);
                    $write_image = 'imagejpeg';
                    break;
                case 'gif':
                    @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                    $src_img = @imagecreatefromgif($file_path);
                    $write_image = 'imagegif';
                    break;
                case 'png':
                    @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                    @imagealphablending($new_img, false);
                    @imagesavealpha($new_img, true);
                    $src_img = @imagecreatefrompng($file_path);
                    $write_image = 'imagepng';
                    break;
                default:
                    $src_img = $image_method = null;
            }
            $success = $src_img && @imagecopyresampled(
                $new_img,
                $src_img,
                0, 0, 0, 0,
                $new_width,
                $new_height,
                $img_width,
                $img_height
            ) && $write_image($new_img, $new_file_path);
            // Free up memory (imagedestroy does not delete files):
            @imagedestroy($src_img);
            @imagedestroy($new_img);
            return $success;
        }
    }

    /**
     * Build error
     * @param string $uploaded_file
     * @param string $file
     * @param string $type
     * @param array $error
     * @return void
     */
    private function has_error($uploaded_file, $file, $type, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->config['accept_file_types'], $file->name) || !$this->config['accept_mime_types'][$type]) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->config['max_file_size'] && (
            $file_size > $this->config['max_file_size'] ||
                $file->size > $this->config['max_file_size'])
        ) {
            return 'maxFileSize';
        }
        if ($this->config['min_file_size'] &&
            $file_size < $this->config['min_file_size']) {
            return 'minFileSize';
        }
        return $error;
    }

    /**
     * Orient image based on file attributes
     * @param string $file_path
     * @return void
     */
    private function orient_image($file_path) {
        $exif = exif_read_data($file_path);
        $orientation = intval(@$exif['Orientation']);
        if (!in_array($orientation, array(3, 6, 8))) {
            return false;
        }
        $image = @imagecreatefromjpeg($file_path);
        switch ($orientation) {
            case 3:
                $image = @imagerotate($image, 180, 0);
                break;
            case 6:
                $image = @imagerotate($image, 270, 0);
                break;
            case 8:
                $image = @imagerotate($image, 90, 0);
                break;
            default:
                return false;
        }
        $success = imagejpeg($image, $file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($image);
        return $success;
    }

    public function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $file->resize_ext = $this->config['accept_mime_types'][$type];
        $file->resize_name = pathinfo($file->name,PATHINFO_FILENAME).'.'.$file->resize_ext;
        // take type and compare with mime options and get ext diff

        $error = $this->has_error($uploaded_file, $file, $type, $error);
        if (!$error && $file->name) {
            $file_path = $this->config['upload_dir'].$file->name;

            $append_file = !$this->config['discard_aborted_uploads'] && is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents($file_path,fopen($uploaded_file, 'r'),FILE_APPEND);
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents($file_path,fopen('php://input', 'r'),$append_file ? FILE_APPEND : 0);
            }
            $file_size = filesize($file_path);

            if ($file_size === $file->size) {
                if ($this->config['orient_image']) {
                    $this->orient_image($file_path);
                }
                foreach($this->config['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $file->resize_name, $options)) {
                        $file->{$version.'_url'} = $options['upload_url'].rawurlencode($file->name);
                    }
                }
            } else if ($this->config['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
        } else {
            $file->error = $error;
        }
        return $file;
    }

    /**
     * Remove file and image versions from server
     * @param string $file_name
     * @param string $alpha_ext
     * @param string $resize_ext
     * @return bool
     */
    public function remove_file($file_name,$alpha_ext,$resize_ext){
        $file_path = $this->config['upload_dir'].$file_name.'.'.$alpha_ext;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach($this->config['image_versions'] as $version => $options) {
                $file = $options['upload_dir'].$file_name.'.'.$resize_ext;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        return $success;
    }

}