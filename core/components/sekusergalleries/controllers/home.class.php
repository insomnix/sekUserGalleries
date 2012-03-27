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

class sekusergalleriesHomeManagerController extends sekugManagerController {
    public function process(array $scriptProperties = array()) {
 
    }
    public function getPageTitle() { return $this->modx->lexicon('sekug.usergalleries'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/groupsettings.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/mimetypes.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/imagesizes.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/reportabuse.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/usersettings.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/albums.grid.js');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->sekug->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() { return $this->sekug->config['templatesPath'].'mgr/home.tpl'; }
}