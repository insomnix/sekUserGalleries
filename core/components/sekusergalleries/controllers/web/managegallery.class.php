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

class sekugManageGalleryController extends sekugController {
    /** @var userid id $userid */
    public $userid;

    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        $loadjquery = $this->modx->getOption('sekusergalleries.load_jquery');
		$this->setDefaultProperties(array(
            'gallery' => '',
            'requireAuth' => true,
            'requireUsergroups' => true,
            'tplFormGallery' => 'users.gallery.form',
            'allowedTags' => '<br><b><i>',
            'preHooks' => '',
            'postHooks' => '',
            'customcss' => '',
            'loadjquery' => $loadjquery,
        ));

        $this->userid = $this->modx->user->get('id');
        $this->setProperty('gallery',$this->userid);
        $store_cover_path = $this->sekug->config['coverImagePath'];

        $this->imgconfig = array(
            'param_name' => 'files',
            'accept_mime_types' => $this->getAcceptedMimeTypesArray(),
            //'script_url' => $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $album_id)),
            'upload_dir' => $store_cover_path.$this->userid.'/alpha/',
            'image_versions' => $this->getImageVersionsArray($this->userid)
        );
    }

    /**
     * Create array of image versions
     * @param int $user_id
     * @return array
     */
    private function getImageVersionsArray($user_id){
        $display_cover_path = $this->sekug->config['coverImagePath'].$user_id.'/';
        $display_cover_url = $this->sekug->config['coverImageUrl'].$user_id.'/';
        $images['thumb'] = array(
            'upload_dir' => $display_cover_path.'thumb/',
            'upload_url' => $display_cover_url.'thumb/',
            'name' => 'thumb',
            'max_width' => $this->modx->getOption('sekusergalleries.gallerycover_thumb_max_width'),
            'max_height' => $this->modx->getOption('sekusergalleries.gallerycover_thumb_max_height'),
            'image_quality' => 90,
        );
        $images['display'] = array(
            'upload_dir' => $display_cover_path.'display/',
            'upload_url' => $display_cover_url.'display/',
            'name' => 'display',
            'max_width' => $this->modx->getOption('sekusergalleries.gallerycover_display_max_width'),
            'max_height' => $this->modx->getOption('sekusergalleries.gallerycover_display_max_height'),
            'image_quality' => 90,
        );

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
            $mimeTypes[$mimeArray['mimetype']] = $mimeArray['resize_ext'];
        }
        return $mimeTypes;
    }

    public function process() {
        $this->preLoad();

        // check if member has permission
        $this->checkPermissions();
		if (!$this->isMember){
           	return $this->modx->lexicon('sekug.notauthorized');
        }
        // check if the gallery exists
        elseif (!$this->checkExists()){
            return 'Problem';
        }
        // check if there is a post request
        elseif ($this->isPost()) {
			if (!$this->loadDictionary()) {
				return 'no Dictionary';
			}
            $fields = $this->validateFields();
			$this->dictionary->reset();
			$this->dictionary->fromArray($fields);

			//$placeholderPrefix = $this->getProperty('placeholderPrefix','');
			if ($this->validator->hasErrors()) {
				$this->modx->toPlaceholders($this->validator->getErrors(),'error');
				$this->modx->setPlaceholder('validation_error',true);
			} else {
	
				$this->loadPreHooks();
				// process hooks 
				if ($this->preHooks->hasErrors()) {
					$this->modx->toPlaceholders($this->preHooks->getErrors(),'error');
					$errorMsg = $this->preHooks->getErrorMessage();
					$this->modx->setPlaceholder('error.message',$errorMsg);
				} else {
                    $file_name = $this->uploadFiles();
                    ($file_name > '') ? $this->dictionary->set('gallery_cover',$file_name) : null;
                    // everything good, go ahead and update gallery
					$result = $this->runProcessor('gallery/update');
					if ($result !== true) {
						$this->modx->setPlaceholder('error.message',$result);
					} else {
						$this->success = true;
						$url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.usersgallery_resource_id'),'','');
						$this->modx->sendRedirect($url);
					}
				}
			}
		}
	
		// load js and css files				
		$this->loadScripts();
		return $this->getForm();
    }

    /**
     * Check if the user's gallery exists, if not, create it
     * @return bool
     */
    public function checkExists(){
        //get the users settings
        $user_gallery = $this->modx->getObject('sekugUserSettings',array(
            'gallery_user' => $this->userid
        ));
        $count = count($user_gallery);
        if(!$count){
            // everything good, go ahead and create gallery
            $result = $this->runProcessor('gallery/create');
            if ($result !== true) {
                $this->modx->setPlaceholder('error.message',$result);
                return false;
            }
        }
        return true;
    }
    /**
     * Do any pre-processing before POST
     * @return void
     */
    public function preLoad() {
        $preHooks = $this->getProperty('preHooks','');
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

    public function getForm() {
        $this->setPlaceholder('username',$this->modx->user->get('username'));
        // get the users settings
        $user_gallery = $this->modx->getObject('sekugUserSettings',array(
            'gallery_user' => $this->userid
        ));
        $this->setPlaceholders(array(
            'gallery_title' => $user_gallery->get('gallery_title'),
            'gallery_description' => $user_gallery->get('gallery_description'),
            'gallery_cover' => $user_gallery->get('gallery_cover'),
            'gallery_cover_url' => $this->sekug->config['coverImageUrl'].'/'.$this->userid.'/thumb/'.$user_gallery->get('gallery_cover'),
            'private' => $user_gallery->get('private'),
            'password' => $user_gallery->get('password'),
        ));
        $this->setPlaceholder('question_image',$this->sekug->config['imagesUrl'].'/question1.png');
		$this->modx->lexicon->load('sekusergalleries:default');
        return $this->sekug->getChunk($this->getProperty('tplFormGallery'),$this->getPlaceholders());
    }
	
    /**
     * Load any pre-hooks
     * @return void
     */
    public function loadPreHooks() {
        $preHooks = $this->getProperty('preHooks','');
        $this->loadHooks('preHooks');
        if (!empty($preHooks)) {
            $fields = $this->dictionary->toArray();
            /* do pre-hooks */
            $this->preHooks->loadMultiple($preHooks,$fields,array(
                'submitVar' => $this->getProperty('submitVar'),
            ));
            $values = $this->preHooks->getValues();
            if (!empty($values)) {
                $this->dictionary->fromArray($values);
            }
        }
    }

    /**
     * Load any scripts for the top of the page
     * @return void
     */
    public function loadScripts() {
        $customcss = $this->getProperty('customcss');
        $loadjquery = $this->getProperty('loadjquery');

        $cssUrl = $this->sekug->config['cssUrl'].'web/';
        $jsUrl = $this->sekug->config['jsUrl'].'web/';

        if($loadjquery == 1){
            $this->modx->regClientStartupScript($jsUrl.'libs/'.$this->sekug->config['jqueryFile']);
        }
        if($customcss>''){
            $this->modx->regClientCSS($this->modx->getOption('assets_url').$customcss);
        } else {
            $this->modx->regClientCSS($cssUrl.'gallery.structure.css');
        }
    }

    public function uploadFiles() {
        $upload = isset($_FILES['upload_image']) ? $_FILES['upload_image'] : null;
        $info = array();
        // start the image handler class
        $this->loadImageHandler($this->imgconfig);

        if ($upload) {
            $info[0] = $this->imagehandler->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                isset($upload['name']) ? $upload['name'] : null,
                isset($upload['size']) ? $upload['size'] : null,
                isset($upload['type']) ? $upload['type'] : null,
                isset($upload['error']) ? $upload['error'] : null
            );

            return $info[0]->resize_name;
        }
        return '';
    }
}
return 'sekugManageGalleryController';