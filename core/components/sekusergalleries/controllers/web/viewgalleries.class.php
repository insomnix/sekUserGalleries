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

class sekugViewGalleriesController extends sekugController {
    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $loadjquery = $this->modx->getOption('sekusergalleries.load_jquery');
        $this->setDefaultProperties(array(
            'tplContainer' => 'browse.galleries.container',
            'tplRow' => 'browse.galleries.row',
            'customcss' => '',
            'loadjquery' => $loadjquery,
        ));
        // if the gallery id is in the request, set it in the properties
        //if (!empty($_REQUEST['gallery'])) {
        //$this->setProperty('gallery', ($_REQUEST['gallery']>'') ? $_REQUEST['gallery'] : $this->modx->user->get('id') );
        //}
    }

    public function process() {
        $this->loadScripts();
        //get the album information
        $sekug_galleries = $this->modx->getCollection('sekugUserSettings');
        $searchItems = '';
        if($sekug_galleries != null){
            foreach ($sekug_galleries as $gallery) {
                $galleryArray = $gallery->toArray();
                $galleryArray['gallery_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.usersgallery_resource_id'),'',array('gallery' => $gallery->get('gallery_user')));
                $galleryArray['gallery_cover_url'] = $this->sekug->config['coverImageUrl'].$gallery->get('gallery_user').'/thumb/'.$gallery->get('gallery_cover');
                $galleryArray['albumcount'] = count($gallery->getMany('sekugAlbums'));
                $searchItems .= $this->sekug->getChunk($this->getProperty('tplRow'),$galleryArray);
            }
            $cont['items'] = $searchItems;
            $cont['count'] = count($sekug_galleries);

            $output = $this->sekug->getChunk($this->getProperty('tplContainer'),$cont);
        }else{
            $output = $this->modx->lexicon('sekug.no.items');
        }
        return $output;
    }

    private function loadScripts(){
        $customcss = $this->getProperty('customcss');
        $loadjquery = $this->getProperty('loadjquery');

        $cssUrl = $this->sekug->config['cssUrl'].'web/';
        $jsUrl = $this->sekug->config['jsUrl'].'web/';

        if($loadjquery == 1){
            $this->modx->regClientStartupScript($jsUrl.'libs/jquery-1.7.1.min.js');
        }
        if($customcss>''){
            $this->modx->regClientCSS($this->modx->getOption('assets_url').$customcss);
        } else {
            $this->modx->regClientCSS($cssUrl.'gallery.structure.css');
        }
    }

}
return 'sekugViewGalleriesController';