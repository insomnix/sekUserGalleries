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

require_once dirname(__FILE__) . '/model/sekusergalleries/sekusergalleries.class.php';
class IndexManagerController extends modExtraManagerController {
    public static function getDefaultController() { return 'home'; }
}
abstract class sekugManagerController extends modManagerController {
    /** @var sekUserGalleries $sekug */
    public $sekug;
    public function initialize() {
        $this->sekug = new sekUserGalleries($this->modx);
 
        //$this->addCss($this->sekug->config['cssUrl'].'mgr/sekug.css');
        $this->addJavascript($this->sekug->config['jsUrl'].'mgr/sekug.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            sekUserGalleries.config = '.$this->modx->toJSON($this->sekug->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('sekusergalleries:default');
    }
    public function checkPermissions() { return true;}
}