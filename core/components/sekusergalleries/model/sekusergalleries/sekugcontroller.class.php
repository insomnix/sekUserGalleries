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

abstract class sekugController {
    /** @var modX $modx */
    public $modx;
    /** @var sekUserGalleries $sekug */
    public $sekug;
    /** @var array $config */
    public $config = array();
    /** @var array $scriptProperties */
    protected $scriptProperties = array();
    /** @var sekugPermissions $permissions */
    public $permissions;
    /** @var sekugDirectory $directory */
    public $directory;
    /** @var sekugValidator $validator */
    public $validator;
    /** @var sekugDictionary $dictionary */
    public $dictionary;
    /** @var sekugImageHandler $imagehandler */
    public $imagehandler;
    /** @var sekugHooks $preHooks */
    public $preHooks;
    /** @var sekugHooks $postHooks */
    public $postHooks;
    /** @var array $placeholders */
    protected $placeholders = array();
    /** @var boolean $isMember */
    public $isMember;

    /**
     * @param sekUserGalleries $sekug A reference to the sekugUserGalleries instance
     * @param array $config
     */
    function __construct(sekUserGalleries &$sekug,array $config = array()) {
        $this->sekug =& $sekug;
        $this->modx =& $sekug->modx;
        $this->config = array_merge($this->config,$config);
    }

    public function run($scriptProperties) {
        $this->setProperties($scriptProperties);
        $this->initialize();
        return $this->process();
    }

    abstract public function initialize();
    abstract public function process();

    /**
     * Set the default options for this module
     * @param array $defaults
     * @return void
     */
    protected function setDefaultProperties(array $defaults = array()) {
        $this->scriptProperties = array_merge($defaults,$this->scriptProperties);
    }

    /**
     * Set an option for this module
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setProperty($key,$value) {
        $this->scriptProperties[$key] = $value;
    }

    /**
     * Set an array of options
     * @param array $array
     * @return void
     */
    public function setProperties($array) {
        foreach ($array as $k => $v) {
            $this->setProperty($k,$v);
        }
    }

    /**
     * Return an array of REQUEST options
     * @return array
     */
    public function getProperties() {
        return $this->scriptProperties;
    }

    /**
     * @param $key
     * @param null $default
     * @param string $method
     * @return mixed
     */
    public function getProperty($key,$default = null,$method = '!empty') {
        $v = $default;
        switch ($method) {
            case 'empty':
            case '!empty':
                if (!empty($this->scriptProperties[$key])) {
                    $v = $this->scriptProperties[$key];
                }
                break;
            case 'isset':
            default:
                if (isset($this->scriptProperties[$key])) {
                    $v = $this->scriptProperties[$key];
                }
                break;
        }
        return $v;
    }

    public function setPlaceholder($k,$v) {
        $this->placeholders[$k] = $v;
    }
    public function getPlaceholder($k,$default = null) {
        return isset($this->placeholders[$k]) ? $this->placeholders[$k] : $default;
    }
    public function setPlaceholders($array) {
        foreach ($array as $k => $v) {
            $this->setPlaceholder($k,$v);
        }
    }
    public function getPlaceholders() {
        return $this->placeholders;
    }

    public function checkPermissions() {
        $this->loadPermissions();
        $this->isMember = $this->permissions->isMember();
    }

    /**
     * Check for a POST submission
     * @return bool
     */
    public function isPost() {
        return !empty($_POST) && (empty($this->scriptProperties['submitVar']) || !empty($_POST[$this->scriptProperties['submitVar']]));
    }

    /**
     * Load the Directory class
     * @param array $config An array of configuration parameters for the
     * sekugDirectory class
     * @return null|sekugDirectory
     */
    public function loadDirectory($config = array()) {
        if (!$this->modx->loadClass('sekugDirectory',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load loadDirectory class.');
            return false;
        }
        $this->directory = new sekugDirectory($this->sekug,$config);
        return $this->directory;
    }

    /**
     * Load the Permissions class
     * @param array $config An array of configuration parameters for the
     * sekugPermissions class
     * @return null|sekugPermissions
     */
    public function loadPermissions($config = array()) {
        if (!$this->modx->loadClass('sekugPermissions',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load loadPermissions class.');
            return false;
        }
        $this->permissions = new sekugPermissions($this->sekug,$config);
        return $this->permissions;
    }

    /**
     * Load the Dictionary class
     * @return sekugDictionary
     */
    public function loadDictionary() {
        if ($this->modx->loadClass('sekugDictionary',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->dictionary = new sekugDictionary($this->sekug);
            $this->dictionary->gather();
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load sekugDictionary class from ');
        }
        return $this->dictionary;
    }

    /**
     * Load the ImageHandler class
     * @param array $config An array of configuration parameters for the
     * sekugImageHandler class
     * @return sekugImageHandler
     */
    public function loadImageHandler($config = array()) {
        if (!$this->modx->loadClass('sekugImageHandler',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load sekugImageHandler class from ');
            return false;
        }
        $this->imagehandler = new sekugImageHandler($this->sekug,$config);
        return $this->imagehandler;
    }

     /**
     * Loads the sekugValidator class.
     *
     * @access public
     * @param array $config An array of configuration parameters for the
     * sekugValidator class
     * @return sekugValidator An instance of the sekugValidator class.
     */
    public function loadValidator($config = array()) {
        if (!$this->modx->loadClass('sekugValidator',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load Validator class.');
            return false;
        }
        $this->validator = new sekugValidator($this->sekug,$config);
        return $this->validator;
    }

    /**
     * Loads the sekugHooks class.
     *
     * @access public
     * @param string $type The name of the Hooks service to load
     * @param array $config array An array of configuration parameters for the
     * hooks class
     * @return sekugHooks An instance of the Hooks class.
     */
    public function loadHooks($type,$config = array()) {
        if (!$this->modx->loadClass('sekugHooks',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load Hooks class.');
            return false;
        }
        $this->$type = new sekugHooks($this->sekug,$this,$config);
        return $this->$type;
    }

    /**
     * @param string $processor
     * @return mixed|string
     */
    public function runProcessor($processor) {
        $output = '';
        $processor = $this->loadProcessor($processor);
        if (empty($processor)) return $output;

        return $processor->process();
    }

    /**
     * @param $processor
     * @return bool|sekugProcessor
     */
    public function loadProcessor($processor) {
        $processorFile = $this->config['processorsPath'].'web/'.strtolower($processor).'.class.php';
        if (!file_exists($processorFile)) {
            return false;
        }
        try {
            $className = 'sekug'.str_replace('/','',ucwords($processor)).'Processor';
            if (!class_exists($className)) {
                $className = include_once $processorFile;
            }
            /** @var sekugProcessor $processor */
            $processor = new $className($this->sekug,$this);
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] '.$e->getMessage());
        }
        return $processor;
    }
}

/**
 * Abstracts processors into a class
 * @package sekusergalleries
 */
abstract class sekugProcessor {
    /** @var sekUserGalleries $sekug */
    public $sekug;
    /** @var sekugController $controller */
    public $controller;
    /** @var sekugDictionary $dictionary */
    public $dictionary;
    /** @var array $config */
    public $config = array();
    
    /**
     * @param sekUserGalleries &$sekug A reference to the usergalleries instance
     * @param sekugController &$controller
     * @param array $config
     */
    function __construct(sekUserGalleries &$sekug,sekugController &$controller,array $config = array()) {
        $this->sekug =& $sekug;
        $this->modx =& $sekug->modx;
        $this->controller =& $controller;
        $this->dictionary =& $controller->dictionary;
        $this->config = array_merge($this->config,$config);
    }

    abstract function process();
}