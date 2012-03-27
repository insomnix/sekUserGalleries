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

class sekugManageDirectoryController extends sekugController {
    /** @var string $directory_name */
    public $directory_name;

    /**
     * Initialize this controller, setting up default properties
     * @return void
     */
    public function initialize() {
        $this->setDefaultProperties(array(
            'tplDirContainer' => 'directory.container',
            'tplDirGraph' => 'directory.bargraph',
        ));

        $this->directory_name = $this->modx->user->get('id');
    }

    public function process() {
        $this->loadScripts();
        $this->loadPermissions();
        $this->loadDirectory();
        $gallery_path = $this->sekug->config['storeGalleryPath'].$this->directory_name.'/';

        $space = $this->permissions->getSpaceAlloted($this->directory);
        $graph = '';
        if($space != null){
            foreach ($space as $sp) {
                $data = $this->directory->getStatistics($gallery_path,$sp['bytes']);
                $data['level'] = $sp['level'];
                $graph .= $this->sekug->getChunk($this->getProperty('tplDirGraph'),$data);
            }
        } else {
            $graph = $this->modx->lexicon('sekug.directory.spacealloted');
        }
        $container['graph'] = $graph;

        return $this->sekug->getChunk($this->getProperty('tplDirContainer'),$container);
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
        $this->modx->regClientCSS($cssUrl.'gallery.structure.css');
        $this->modx->regClientCSS($cssUrl.'directory.graph.css');
    }
}
return 'sekugManageDirectoryController';