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

class sekugSearchController extends sekugController {
    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $this->setDefaultProperties(array(
            'tplContainer' => 'search.container',
            'tplAlbumList' => 'users.gallery.albumlist',
        ));
    }

    public function process() {
        $this->loadScripts();
        if (!$this->loadDictionary()) {
            return 'no Dictionary';
        }
        $fields = $this->validateFields();
        $this->dictionary->reset();
        $this->dictionary->fromArray($fields);

        $c = $this->modx->newQuery('sekugAlbums');
        $search = explode(' ',$this->dictionary->get('search'));
        foreach($search as $item){
            $c->where(array(
                'album_title:LIKE' => '%'.$item.'%',
                'OR:album_description:LIKE' => '%'.$item.'%',
                'OR:album_keywords:LIKE' => '%'.$item.'%',
                'private' => '0'
            ));
        }
        $albums = $this->modx->getCollection('sekugAlbums',$c);

        $albumItems='';
        if($albums != null){
            $albumsRow = '';
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
            $searchArray['count'] = count($albums);
            $searchArray['items'] = $albumItems;
            $searchArray['search'] = $this->dictionary->get('search');
            $output = $this->sekug->getChunk($this->getProperty('tplContainer'),$searchArray);
        }else{
            $output = $this->modx->lexicon('sekug.noalbums');
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

    private function loadScripts(){
        $cssUrl = $this->sekug->config['cssUrl'].'web/';
        $jsUrl = $this->sekug->config['jsUrl'].'web/';

        if($this->modx->getOption('sekusergalleries.load_jquery') == 1){
            $this->modx->regClientStartupScript($jsUrl.'libs/jquery-1.7.1.min.js');
        }
        $this->modx->regClientCSS($cssUrl.'gallery.structure.css');
    }

}
return 'sekugSearchController';