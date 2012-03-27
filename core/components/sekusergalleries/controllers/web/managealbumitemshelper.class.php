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

class sekugManageAlbumItemsHelperController extends sekugController {
    public $success = false;

    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $this->setDefaultProperties(array(
            'album' => '',
            'albumitem' => '',
            'requireAuth' => true,
            'requireUsergroups' => true,
            'allowedTags' => '<br><b><i>',
        ));

        // if the album id is in the request, set it in the properties
        if (!empty($_REQUEST['album'])) {
            $this->setProperty('album',$_REQUEST['album']);
        }

        $user_id = $this->modx->user->get('id');
        $album_id = $this->getProperty('album');
        // if the user id and album id are set, continue
        if ($album_id > '' && $user_id > ''){
            // create the paths for the album data
            $store_gallery_path = $this->sekug->config['storeGalleryPath'].$user_id.'/'.$album_id.'/';
            //set the default properties
            $this->imgconfig = array(
                'param_name' => 'files',
                'accept_mime_types' => $this->getAcceptedMimeTypesArray(),
                'script_url' => $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $album_id)),
                'upload_dir' => $store_gallery_path.'alpha/',
                'image_versions' => $this->getImageVersionsArray($user_id,$album_id)
            );
        }
    }

    /**
     * Create array of image versions
     * @param int $user_id
     * @param int $album_id
     * @return array
     */
    private function getImageVersionsArray($user_id,$album_id){
        $display_gallery_path = $this->sekug->config['displayGalleryPath'].$user_id.'/'.$album_id.'/';
        $display_gallery_url = $this->sekug->config['displayGalleryUrl'].$user_id.'/'.$album_id.'/';
        $watermark_folder = $this->sekug->config['storeGalleryPath'].'watermarks/';
        $images['thumb'] = array(
                'name' => 'thumb',
                'upload_dir' => $display_gallery_path.'thumb/',
                'upload_url' => $display_gallery_url.'thumb/',
                'max_width' => $this->modx->getOption('sekusergalleries.image_thumb_max_width'),
                'max_height' => $this->modx->getOption('sekusergalleries.image_thumb_max_height'),
                'image_quality' => 90,
        );
        $image_sizes = $this->modx->getCollection('sekugImageSizes');
        foreach ($image_sizes as $image_size) {
            $sizeArray = $image_size->toArray();
            $images[$sizeArray['name']] = array(
                'upload_dir' => $display_gallery_path.$sizeArray['name'].'/',
                'upload_url' => $display_gallery_url.$sizeArray['name'].'/',
                'name' => $sizeArray['name'],
                'description' => $sizeArray['description'],
                'max_width' => $sizeArray['max_width'],
                'max_height' => $sizeArray['max_height'],
                'image_quality' => $sizeArray['image_quality'],
                'watermark_image' => ($sizeArray['watermark_image']>'') ? $watermark_folder . $sizeArray['watermark_image'] : '',
                'watermark_text' => $sizeArray['watermark_text'],
                'watermark_text_color' => $sizeArray['watermark_text_color'],
                'watermark_font' => $sizeArray['watermark_font'],
                'watermark_font_size' => $sizeArray['watermark_font_size'],
                'watermark_location' => $sizeArray['watermark_location'],
                'watermark_brightness' => $sizeArray['watermark_brightness'],
                'primary' => $sizeArray['primary']
            );
        }
        return $images;
    }

    /**
     * Create array of accepted mime types
     * @return array
     */
    private function getAcceptedMimeTypesArray(){
        $mimeTypes = '';
        $image_sizes = $this->modx->getCollection('sekugMimeTypes');
        foreach ($image_sizes as $image_size) {
            $mimeArray = $image_size->toArray();
            $mimeTypes[$mimeArray['mimetype']] =  $mimeArray['resize_ext'];
        }
        return $mimeTypes;
    }

    public function process() {
        $this->checkPermissions();
        if (!$this->isMember){
            return $this->modx->lexicon('sekug.notauthorized');
        }elseif(!$this->isOwner()){
            return $this->modx->lexicon('sekug.notalbumowner');
        }
        header('Pragma: no-cache');
        header('Cache-Control: private, no-cache');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        // start the image handler class
        $this->loadImageHandler($this->imgconfig);
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                return $this->getFiles();
                break;
            case 'POST':
                return $this->uploadFiles();
                break;
            case 'DELETE':
                return $this->deleteFiles();
                break;
            case 'UPDATE':
                return $this->updateFiles();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
        return null;
    }

    /**
     * Verify the owner of the album
     * @return bool
     */
    public function isOwner(){
        $sekug_album = $this->modx->getCollection('sekugAlbums',array(
            'id' => $this->getProperty('album'),
            'album_user' => $this->modx->user->get('id')
        ));
        if($sekug_album != null){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Validate the fields in the form
     * @return array
     */
    public function validateFields() {
        $this->loadValidator();
        $fields = $this->validator->validateFields($this->dictionary,$this->getProperty('validate',''));
        foreach ($fields as $k => $v) {
            $fields[$k] = str_replace(array('[',']'),array('&#91;','&#93;'),$v);
        }
        return $fields;
    }

    private function get_album_item($itemid) {
        $album_id = $this->getProperty('album');
        $user_id = $this->modx->user->get('id');
        $display_gallery_url = $this->sekug->config['displayGalleryUrl'].$user_id.'/'.$album_id.'/';

        $item = $this->modx->getObject('sekugAlbumItems', $itemid);

        if ($item != null) {
            $itemArray = $item->toArray();
            $file = new stdClass();
            $file->id = $itemArray['id'];
            $file->name = $itemArray['file_name'] . '.' .$itemArray['file_ext_resize'];
            $file_path = $this->sekug->config['storeGalleryPath'].$user_id.'/'.$album_id.'/alpha/'.$file->name;
            $file->size = (is_file($file_path)) ? filesize($file_path) : 0;
            $file->title = $itemArray['item_title'];
            $file->description = $itemArray['item_description'];
            $file->thumbnail_url = $display_gallery_url.'thumb/'.$file->name;
            foreach ($this->imgconfig['image_versions'] as $index => $value) {
                if($this->imgconfig['image_versions'][$index]['primary']==1){
                    $file->primary_url = $display_gallery_url.$this->imgconfig['image_versions'][$index]['name'].'/'.$file->name;
                }
            }
            $file->update_url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $this->getProperty('album'), 'item' => $itemArray['id']));
            $file->update_type = 'UPDATE';
            $file->delete_url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $this->getProperty('album'), 'item' => $itemArray['id']));
            $file->delete_type = 'DELETE';
            return $file;
        }
        return null;
    }

    private function get_album_items() {
        $album_id = $this->getProperty('album');
        $query = $this->modx->newQuery('sekugAlbumItems');
        $query->select('id');
        $query->where(array('album_id' => $album_id));
        $items = $this->modx->getCollection('sekugAlbumItems',$query);
        foreach ($items as $item) {
            $itemArray = $item->toArray();
            $arr[]=$itemArray['id'];
        }
        return array_values(array_filter(array_map( array($this, 'get_album_item'), $arr)));
    }

    private function handle_post($file){
        if (!$this->loadDictionary()) {
            return 'no Dictionary';
        }
        $album_id = $this->getProperty('album');
        $user_id = $this->modx->user->get('id');
        $display_gallery_url = $this->sekug->config['displayGalleryUrl'].$user_id.'/'.$album_id.'/';

        $this->dictionary->set('file_name',pathinfo($file->name,PATHINFO_FILENAME));
        $this->dictionary->set('file_ext',pathinfo($file->name,PATHINFO_EXTENSION));
        $this->dictionary->set('file_ext_resize',$file->resize_ext);
        $this->dictionary->set('album_id',$this->getProperty('album'));
        $this->dictionary->set('item_title',$_POST['item_title'][$file->name]);
        $this->dictionary->set('item_description',$_POST['item_description'][$file->name]);

        $storeAlbumPath = $this->sekug->config['storeGalleryPath'] . $user_id . '/' . $album_id . '/';
        $image_path  = $storeAlbumPath . 'alpha/' . $this->dictionary->get('file_name') . '.' . $this->dictionary->get('file_ext');

        $image_info = $this->sekug->getImageInformation($image_path);
        $this->dictionary->set('file_datetime',$image_info['date']);

        $fields = $this->validateFields();
        $this->dictionary->reset();
        $this->dictionary->fromArray($fields);

        if ($this->validator->hasErrors()) {
            $this->modx->toPlaceholders($this->validator->getErrors(),'error');
            $this->modx->setPlaceholder('validation_error',true);
        } else {
            // everything good, go ahead and add item
            $result = $this->runProcessor('albumitems/create');
            if ($result !== true) {
                $this->modx->setPlaceholder('error.message',$result);
            } else {
                $this->success = true;
                $file->id = $this->getProperty('albumitem');
                $file->title = $this->dictionary->get('item_title');
                $file->description = $this->dictionary->get('item_description');
                $file->thumbnail_url = $display_gallery_url.'thumb/'.$this->dictionary->get('file_name').'.'.$this->dictionary->get('file_ext_resize');
                foreach ($this->imgconfig['image_versions'] as $index => $value) {
                    if($this->imgconfig['image_versions'][$index]['primary']=1){
                        $file->primary_url = $display_gallery_url.$this->imgconfig['image_versions'][$index]['name'].'/'.$this->dictionary->get('file_name').'.'.$this->dictionary->get('file_ext_resize');
                    }
                }
                $file->update_url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $this->getProperty('album'), 'item' => $file->id));
                $file->update_type = 'UPDATE';
                $file->delete_url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $this->getProperty('album'), 'item' => $file->id));
                $file->delete_type = 'DELETE';

                return $file;
            }
        }
    }

    private function space_available($file_size){
        $this->loadPermissions();
        $this->loadDirectory();
        $gallery_path = $this->sekug->config['storeGalleryPath'].$this->modx->user->get('id').'/';

        $space = $this->permissions->getSpaceAlloted($this->directory,true);
        if($space != null){
            foreach ($space as $sp) {
                $data = $this->directory->getStatistics($gallery_path,$sp['bytes']-$file_size);
                if($data['percentage_used'] >= 100){
                    return false;
                }else{
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public function uploadFiles() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->deleteFiles();
        }
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'UPDATE') {
            return $this->updateFiles();
        }
        $upload = isset($_FILES[$this->imgconfig['param_name']]) ? $_FILES[$this->imgconfig['param_name']] : null;
        $info = array();

        if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                // check that there is space left for user
                if( $this->space_available(isset($_SERVER['HTTP_X_FILE_SIZE']) ?  $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index]) ){
                    // $info is an array of stdClass values
                    $info[$index] = $this->imagehandler->handle_file_upload(
                        $upload['tmp_name'][$index],
                        isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                        isset($_SERVER['HTTP_X_FILE_SIZE']) ?  $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                        isset($_SERVER['HTTP_X_FILE_TYPE']) ?  $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                        $upload['error'][$index]
                    );
                    // multiple file upload here
                    if($info[$index]->error == null){
                        $info[$index] = $this->handle_post($info[$index]);
                    }
                }else{
                    $info[$index]->error = 'maxSpaceUsed';
                }
            }
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            // check that there is space left for user
            if( $this->space_available(isset($_SERVER['HTTP_X_FILE_SIZE']) ?  $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size']) ){
                $info[0] = $this->imagehandler->handle_file_upload(
                    isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                    isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ? isset($upload['name']) : null),
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ? isset($upload['size']) : null),
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ? isset($upload['type']) : null),
                    isset($upload['error']) ? $upload['error'] : null
                );
                // single upload info here
                if($info[0]->error == null){
                    $info[0] = $this->handle_post($info[0]);
                }
            }else{
                $info[0]->error = 'maxSpaceUsed';
            }
        }

        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        return $json;
    }

    public function getFiles() {
        $item_id = isset($_REQUEST['item']) ? $_REQUEST['item'] : null;
        if ($item_id) {
            $info = $this->get_album_item($item_id);
        } else {
            $info = $this->get_album_items();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function deleteFiles() {
        $success = false;
        $itemid = isset($_REQUEST['item']) ? $_REQUEST['item'] : null;
        $item = $this->modx->getObject('sekugAlbumItems', $itemid);
        if ($item != null) {
            $itemArray = $item->toArray();
            $success = $this->imagehandler->remove_file($itemArray['file_name'],$itemArray['file_ext'],$itemArray['file_ext_resize']);
        }
        $this->runProcessor('albumitems/remove');
        header('Content-type: application/json');
        echo json_encode($success);
    }

    public function updateFiles() {
        /*$success = false;
        $itemid = isset($_REQUEST['item']) ? $_REQUEST['item'] : null;
        $item = $this->modx->getObject('sekugAlbumItems', $itemid);
        if ($item != null) {
            $itemArray = $item->toArray();
            $success = $this->imagehandler->remove_file($itemArray['file_name'],$itemArray['file_ext'],$itemArray['file_ext_resize']);
        }*/
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries]: '.$_REQUEST['item']);

        if (!$this->loadDictionary()) {
            return 'no Dictionary';
        }

        $this->dictionary->set('item_title',$_POST['item_title'][$_REQUEST['item']]);
        $this->dictionary->set('item_description',$_POST['item_description'][$_REQUEST['item']]);

        $fields = $this->validateFields();
        $this->dictionary->reset();
        $this->dictionary->fromArray($fields);

        $this->runProcessor('albumitems/update');
        header('Content-type: application/json');
        echo json_encode('true');
    }
}
return 'sekugManageAlbumItemsHelperController';