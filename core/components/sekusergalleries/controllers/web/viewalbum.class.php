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
class sekugViewAlbumController extends sekugController {
    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $loadjquery = $this->modx->getOption('sekusergalleries.load_jquery');
        $this->setDefaultProperties(array(
            'album' => '',
            'tplAlbum' => 'album.view',
            'tplAlbumItems' => 'album.items.list',
            'tplAltItems' => 'album.items.alt',
            'tplPasswordForm' => 'album.password.form',
            'customcss' => '',
            'loadjquery' => $loadjquery,
        ));
        // if the album id is in the request, set it in the properties
        if (!empty($_REQUEST['album'])) {
            $this->setProperty('album',$_REQUEST['album']);
        }
    }

    public function process() {
        if ($this->isPost()) {
            $this->handlePost();
        }
        $this->loadScripts();

        $sekug_album = $this->modx->getObject('sekugAlbums',array(
            'id' => $this->getProperty('album')
        ));

        if($sekug_album != null){
            $album['album_id'] = $sekug_album->get('id');
            $album['album_title'] = $sekug_album->get('album_title');
            $album['album_description'] = $sekug_album->get('album_description');
            $album['album_keywords'] = $sekug_album->get('album_keywords');

            if(!($sekug_album->get('album_user') != $this->modx->user->get('id') && $sekug_album->get('password') > '') || $sekug_album->get('password') == $_SESSION['album'.$sekug_album->get('id')]){
                $baseAlbumUrl = $this->sekug->config['displayGalleryUrl'] . $sekug_album->get('album_user') . '/' . $sekug_album->get('id') . '/';
                //$storeAlbumPath = $this->sekug->config['storeGalleryPath'] . $sekug_album->get('album_user') . '/' . $sekug_album->get('id') . '/';
                $items = $sekug_album->getMany('sekugAlbumItems');
                $albumItems='';
                // get the image sizes to display
                $image_sizes = $this->modx->getCollection('sekugImageSizes');
                foreach ($image_sizes as $image_size) {
                    $sizeArray = $image_size->toArray();
                    $images[$sizeArray['name']] = array(
                        'name' => $sizeArray['name'],
                        'description' => $sizeArray['description'],
                        'max_width' => $sizeArray['max_width'],
                        'max_height' => $sizeArray['max_height'],
                        'image_quality' => $sizeArray['image_quality'],
                        //'watermark_image' => ($sizeArray['watermark_image']>'') ? $watermark_folder . $sizeArray['watermark_image'] : '',
                        //'watermark_text' => $sizeArray['watermark_text'],
                        //'watermark_text_color' => $sizeArray['watermark_text_color'],
                        //'watermark_font' => $sizeArray['watermark_font'],
                        //'watermark_font_size' => $sizeArray['watermark_font_size'],
                        //'watermark_location' => $sizeArray['watermark_location'],
                        //'watermark_brightness' => $sizeArray['watermark_brightness'],
                        'primary' => $sizeArray['primary']
                    );
                }
                foreach ($items as $item) {
                    $itemArray = $item->toArray();
                    $primary_image = '';
                    $alt_images = '';
                    foreach ($image_sizes as $image_size) {
                        $imageArray = $image_size->toArray();
                        if($imageArray['primary']==1){
                            $primary_image = $baseAlbumUrl.$imageArray['name'].'/'.$itemArray['file_name'] . '.' .$itemArray['file_ext_resize'];
                        }else{
                            $imageArray['image'] = $baseAlbumUrl.$imageArray['name'].'/'.$itemArray['file_name'] . '.' .$itemArray['file_ext_resize'];
                            $imageArray['item_title'] = $itemArray['item_title'];
                            $alt_images .= $this->sekug->getChunk($this->getProperty('tplAltItems'),$imageArray);
                        }
                    }
                    $itemArray['add_favorite_url'] = ($this->modx->getOption('sekusergalleries.favorites_helper_resource_id')>'') ? $this->modx->makeUrl($this->modx->getOption('sekusergalleries.favorites_helper_resource_id'),'',array('action' => 'addToFavorites','albumItemID' => $itemArray['id'])) : '';;
                    $itemArray['primary_image'] = $primary_image;
                    $itemArray['alt_images'] = $alt_images;
                    $itemArray['thumbnail_image'] = $baseAlbumUrl . 'thumb/' . $itemArray['file_name'] . '.' .$itemArray['file_ext_resize'];
                    $itemArray['image_info_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.image_info_resource_id'),'',array('item' => $itemArray['id']));
                    $albumItems .= $this->sekug->getChunk($this->getProperty('tplAlbumItems'),$itemArray);
                }
                $album['item_list'] = $albumItems;
                $album['item_count'] = count($items);
            }else{
                // get the password form if album is password protected
                $formfield['album_id'] = $sekug_album->get('id');
                $albumArray['album_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.album_view_resource_id'),'',array('album' => $sekug_album->get('id')));
                $album['item_list'] = $this->sekug->getChunk($this->getProperty('tplPasswordForm'),$formfield);
            }
            $output = $this->sekug->getChunk($this->getProperty('tplAlbum'),$album);
        }else{
            $output = $this->modx->lexicon('sekug.album.not.exist');
        }
        return $output;
    }

    private function handlePost(){
        if (!$this->loadDictionary()) {
            return 'no Dictionary';
        }
        $_SESSION['album'.$this->dictionary->get('album_id')] = $this->dictionary->get('password');
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
return 'sekugViewAlbumController';