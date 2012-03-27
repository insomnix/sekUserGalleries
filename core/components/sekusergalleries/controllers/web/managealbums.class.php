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

class sekugManageAlbumsController extends sekugController {
    /** @var album id $album */
    //public $album;

    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
		$this->setDefaultProperties(array(
            'album' => '',
            'action' => '',
            'requireAuth' => true,
            'requireUsergroups' => true,
            'tplFormAlbum' => 'album.form',
            'tplDeleteConfirmation' => 'album.delete',
            'allowedTags' => '<br><b><i>',
            'preHooks' => '',
            'postHooks' => '',
        ));

        if (!empty($_REQUEST['album'])) {
            $this->setProperty('album',$_REQUEST['album']);
        }
        if (!empty($_REQUEST['action'])) {
            $this->setProperty('action',$_REQUEST['action']);
        }
    }

    public function process() {
        $this->preLoad();

        // check if member has permission
        $this->checkPermissions();
        if (!$this->isMember){
            return $this->modx->lexicon('sekug.notauthorized');
        }
		
        if ($this->isPost()) {
			if (!$this->loadDictionary()) {
				return 'no Dictionary';
			}
            if($this->dictionary->get('album_id') > ''){
                $this->setProperty('album',$this->dictionary->get('album_id'));
            }
            if($this->dictionary->get('action') > ''){
                $this->setProperty('action',$this->dictionary->get('action'));
            }

            if($this->getProperty('action') == 'del'){
                if($this->isOwner()){
                    // everything good, go ahead and remove album
                    $result = $this->runProcessor('albums/remove');
                    $url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.usersgallery_resource_id'));
                    if ($result !== true) {
                        $this->modx->setPlaceholder('error.message',$result);
                    } else {
                        $user_id = $this->modx->user->get('id');
                        $album_id = $this->getProperty('album');
                        // if the user id and album id are set, continue
                        if ($album_id > '' && $user_id > ''){
                            // create the paths for the album data
                            $this->loadDirectory();
                            $store_gallery_path = $this->sekug->config['storeGalleryPath'].$user_id.'/'.$album_id;
                            $this->directory->rrmdir($store_gallery_path);
                            $display_gallery_path = $this->sekug->config['displayGalleryPath'].$user_id.'/'.$album_id;
                            $this->directory->rrmdir($display_gallery_path);
                        }
                        $this->modx->sendRedirect($url);
                    }
                }
            }

            $fields = $this->validateFields();
			$this->dictionary->reset();
			$this->dictionary->fromArray($fields);

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
                    if($this->getProperty('album')>''){
                        if($this->isOwner()){
                            // everything good, go ahead and update album
                            $result = $this->runProcessor('albums/update');
                            $url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.usersgallery_resource_id'));
                        }else{
                            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not update album by user: '.$this->modx->user->get('username').' album '.$this->getProperty('album'));
                            return $this->modx->lexicon('sekug.notalbumowner');
                        }
                    }else{
                        // everything good, go ahead and add album
                        $result = $this->runProcessor('albums/create');
                        $url = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_manage_resource_id'),'',array('album' => $this->getProperty('album')));
                    }
					if ($result !== true) {
						$this->modx->setPlaceholder('error.message',$result);
					} else {
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
        // $this->setPlaceholder('username',$this->modx->user->get('username'));
        // get the users settings
        if($this->getProperty('album')>''){
            if($this->isOwner()){
                $user_album = $this->modx->getObject('sekugAlbums',array(
                    'id' => $this->getProperty('album')
                ));
                $this->setPlaceholders(array(
                    'album_id' => $user_album->get('id'),
                    'album_title' => $user_album->get('album_title'),
                    'album_description' => $user_album->get('album_description'),
                    'album_keywords' => $user_album->get('album_keywords'),
                    'album_cover' => $user_album->get('album_cover'),
                    'album_parent' => $user_album->get('album_parent'),
                    'active_from' => $user_album->get('active_from'),
                    'active_to' => $user_album->get('active_to'),
                    'private' => $user_album->get('private'),
                    'password' => $user_album->get('password'),
                ));
            }else{
                return $this->modx->lexicon('sekug.notalbumowner');
            }
        }
        $this->setPlaceholder('thumbcomboboxwidth',$this->modx->getOption('sekusergalleries.image_thumb_max_width') + 50);
		$this->setPlaceholder('question_image',$this->sekug->config['imagesUrl'].'/question1.png');
		$this->modx->lexicon->load('sekusergalleries:default');
        if($this->getProperty('action') == 'del'){
            return $this->sekug->getChunk($this->getProperty('tplDeleteConfirmation'),$this->getPlaceholders());
        }else{
            return $this->sekug->getChunk($this->getProperty('tplFormAlbum'),$this->getPlaceholders());
        }
    }

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
     * Load any hooks
     * @return void
     */
    public function loadPreHooks() {
        $preHooks = $this->getProperty('preHooks','');
        $this->loadHooks('preHooks');
        
        if (!empty($preHooks)) {
            $fields = $this->dictionary->toArray();
            /* do pre-register hooks */
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
        $cssUrl = $this->sekug->config['cssUrl'].'web/';
        $jsUrl = $this->sekug->config['jsUrl'].'web/';

        if($this->modx->getOption('sekusergalleries.load_jquery') == 1){
            $this->modx->regClientStartupScript($jsUrl.'libs/jquery-1.7.1.min.js');
        }
		$this->modx->regClientStartupScript($jsUrl.'libs/jquery-ui-1.8.17.custom.min.js');
        $this->modx->regClientCSS($cssUrl.'gallery.structure.css');
		$this->modx->regClientCSS($cssUrl.'smoothness/jquery-ui-1.8.17.custom.css');
		$datepicker = '<script>
				$(function() {
					$( ".datepicker" ).datepicker();
				});
			</script>';
		$this->modx->regClientScript($datepicker);
    }

}
return 'sekugManageAlbumsController';