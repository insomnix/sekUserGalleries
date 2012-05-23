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
class sekugManageAlbumItemsController extends sekugController {
    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        // set the default properties for the sekugManageAlbumItemsController class
        $loadjquery = $this->modx->getOption('sekusergalleries.load_jquery');
        $this->setDefaultProperties(array(
            'album' => '',
            'tplItemsForm' => 'album.items.form',
            'tplJsDisplay' => 'album.items.js.display',
            'tplJsUpload' => 'album.items.js.upload',
            'customcss' => '',
            'loadjquery' => $loadjquery,
        ));
        // if the album id is in the request, set it in the properties
        if (!empty($_REQUEST['album'])) {
            $this->setProperty('album',$_REQUEST['album']);
        }
    }

    public function process() {
        $this->checkPermissions();
        if (!$this->isMember){
            return $this->modx->lexicon('sekug.notauthorized');
        }elseif(!$this->isOwner()){
            return $this->modx->lexicon('sekug.notalbumowner');
        }
        $this->loadScripts();

        //get the album information
        $sekug_album = $this->modx->getObject('sekugAlbums',array(
            'id' => $this->getProperty('album')
        ));

        if($sekug_album != null){
            $album['album_id'] = $sekug_album->get('id');
            $album['album_title'] = $sekug_album->get('album_title');
            $album['album_description'] = $sekug_album->get('album_description');
            $album['album_upload_url'] = $this->modx->makeUrl($this->modx->getOption('sekusergalleries.items_helper_resource_id'),'',array('album' => $sekug_album->get('id')));

            $album['my_gallery_url'] =  ($this->modx->getOption('sekusergalleries.usersgallery_resource_id')>'') ? $this->modx->makeUrl($this->modx->getOption('sekusergalleries.usersgallery_resource_id')) : '';
            $album['update_album_url'] =  ($this->modx->getOption('sekusergalleries.album_manage_resource_id')>'') ? $this->modx->makeUrl($this->modx->getOption('sekusergalleries.album_manage_resource_id'),'',array('album' => $sekug_album->get('id'))) : '';
            $output = $this->sekug->getChunk($this->getProperty('tplItemsForm'),$album);
        }else{
            $output = $this->modx->lexicon('sekug.album.not.exist');
        }

        return $output;
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
        $this->modx->regClientCSS($cssUrl.'jqueryupload/bootstrap.min.css');
        $this->modx->regClientCSS($cssUrl.'jqueryupload/bootstrap-responsive.min.css');
        $this->modx->regClientCSS($cssUrl.'jqueryupload/jquery.fileupload-ui.css');
        $src = "<script>
                var fileUploadErrors = {
                    maxFileSize: '".$this->modx->lexicon('sekug.maxfilesize')."',
                    minFileSize: '".$this->modx->lexicon('sekug.minfilesize')."',
                    acceptFileTypes: '".$this->modx->lexicon('sekug.acceptfiletypes')."',
                    maxNumberOfFiles: '".$this->modx->lexicon('sekug.maxnumberoffiles')."',
                    maxSpaceUsed: '".$this->modx->lexicon('sekug.maxspaceused')."',
                    uploadedBytes: '".$this->modx->lexicon('sekug.uploadedbytes')."',
                    emptyResult: '".$this->modx->lexicon('sekug.emptyresult')."'
                };
                </script>";
        $this->modx->regClientScript($src);
        $src = $this->sekug->getChunk($this->getProperty('tplJsDisplay'),'');
        $this->modx->regClientScript($src);
        $src = $this->sekug->getChunk($this->getProperty('tplJsUpload'),'');
        $this->modx->regClientScript($src);

        //-- The Templates and Load Image plugins are included for the FileUpload user interface --
        $this->modx->regClientScript($jsUrl.'jqueryupload/tmpl.min.js');
        $this->modx->regClientScript($jsUrl.'jqueryupload/load-image.min.js');
        //-- The jQuery UI widget factory, can be omitted if jQuery UI is already included --
        $this->modx->regClientScript($jsUrl.'libs/jquery.ui.widget.js');
        //-- The Iframe Transport is required for browsers without support for XHR file uploads --
        $this->modx->regClientScript($jsUrl.'jqueryupload/jquery.iframe-transport.js');
        $this->modx->regClientScript($jsUrl.'jqueryupload/jquery.fileupload.js');
        $this->modx->regClientScript($jsUrl.'jqueryupload/jquery.fileupload-ui.js');
        $this->modx->regClientScript($jsUrl.'jqueryupload/application.js');
        //-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ --
        $this->modx->regClientScript($jsUrl.'jqueryupload/cors/jquery.xdr-transport.js');
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
}
return 'sekugManageAlbumItemsController';