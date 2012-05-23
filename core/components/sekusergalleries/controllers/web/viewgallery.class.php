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

class sekugViewGalleryController extends sekugController {
    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $loadjquery = $this->modx->getOption('sekusergalleries.load_jquery');
        $this->setDefaultProperties(array(
            'gallery' => '',
            'tplGallery' => 'users.gallery.view',
            'tplAlbumList' => 'users.gallery.albumlist',
            'customcss' => '',
            'loadjquery' => $loadjquery,
        ));
        // if the gallery id is in the request, set it in the properties
        //if (!empty($_REQUEST['gallery'])) {
            $this->setProperty('gallery', ($_REQUEST['gallery']>'') ? $_REQUEST['gallery'] : $this->modx->user->get('id') );
        //}
    }

    public function process() {
        /*        $this->checkPermissions();
        if (!$this->isMember){
            return $this->modx->lexicon('sekug.notauthorized');
        }*/
        $this->loadScripts();

        $user_gallery = $this->modx->getObject('sekugUserSettings',array(
            'gallery_user' => $this->getProperty('gallery')
        ));
        $albumItems='';
        if($user_gallery != null){
            $gallery['gallery_title'] = $user_gallery->get('gallery_title');
            $gallery['gallery_description'] = $user_gallery->get('gallery_description');
            $gallery['gallery_cover'] = $user_gallery->get('gallery_cover');
            $gallery['gallery_cover_url'] = $this->sekug->config['coverImageUrl'].$user_gallery->get('gallery_user').'/thumb/'.$user_gallery->get('gallery_cover');

            $albums = $user_gallery->getMany('sekugAlbums');
            foreach ($albums as $album) {
                $albumArray = $album->toArray();
                // make sure that, if the album is private, the viewer is the owner
                if(!($albumArray['album_user'] != $this->modx->user->get('id') && $albumArray['private'] == 1)){
                    // make sure only the owner has access to the managment links
                    if($albumArray['album_user'] == $this->modx->user->get('id')){
                        $albumArray['manage_items_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_manage_resource_id'),'',array('album' => $albumArray['id']));
                        $albumArray['update_album_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.album_manage_resource_id'),'',array('album' => $albumArray['id']));
                        $albumArray['delete_album_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.album_manage_resource_id'),'',array('album' => $albumArray['id'],'action' => 'del'));
                    }
                    $albumArray['album_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.album_view_resource_id'),'',array('album' => $albumArray['id']));
                    $display_gallery_url = $this->sekug->config['displayGalleryUrl'].$albumArray['album_user'].'/'.$albumArray['id'].'/thumb/';
                    if($albumArray['album_cover'] > 0){
                        $albumimage = $this->modx->getObject('sekugAlbumItems',array(
                            'id' => $albumArray['album_cover']
                        ));
                        if($albumimage != null){
                            $albumArray['thumb'] = $display_gallery_url.$albumimage->get('file_name').'.'.$albumimage->get('file_ext_resize');
                        }else{
                            $albumArray['thumb'] = $this->getRandomImage($album, $display_gallery_url);
                        }
                    }else{
                        $albumArray['thumb'] = $this->getRandomImage($album, $display_gallery_url);
                    }
                    $albumItems .= $this->sekug->getChunk($this->getProperty('tplAlbumList'),$albumArray);
                }
            }
            $gallery['album_list'] = $albumItems;
            $gallery['album_count'] = count($albums);
            $output = $this->sekug->getChunk($this->getProperty('tplGallery'),$gallery);
        }else{
            $this->checkPermissions();
            if (!$this->isMember){
                return $this->modx->lexicon('sekug.nogalleryselected');
            }else{
                return $this->modx->lexicon('sekug.setupgallery');
            }
        }
        return $output;
    }

    private function getRandomImage($album, $path_url){
        $albumimages = $album->getMany('sekugAlbumItems');
        if($albumimages != null){
            $arr = array();
            foreach ($albumimages as $image) {
                $itemArray = $image->toArray();
                $arr[]=$itemArray;
            }
            $randkey = array_rand($arr);
            return $path_url.$arr[$randkey]['file_name'].'.'.$arr[$randkey]['file_ext_resize'];
            $arr = null;
        }
        return '';
    }

    private function loadScripts(){
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

}
return 'sekugViewGalleryController';