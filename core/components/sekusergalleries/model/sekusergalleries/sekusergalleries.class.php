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

class sekUserGalleries {
    public $modx;
    public $config = array();
	
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
 
        $basePath = $this->modx->getOption('sekusergalleries.core_path',$config,$this->modx->getOption('core_path').'components/sekusergalleries/');
        $assetsUrl = $this->modx->getOption('sekusergalleries.assets_url',$config,$this->modx->getOption('assets_url').'components/sekusergalleries/');
        $assetsPath = $this->modx->getOption('sekusergalleries.assets_path',$config,$this->modx->getOption('assets_path').'components/sekusergalleries/');
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'controllersPath' => $basePath.'controllers/',
            'processorsPath' => $basePath.'processors/',
			'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'storeGalleryPath' => $basePath.'galleries/',
            'displayGalleryPath' => $assetsPath.'galleries/',
            'displayGalleryUrl' => $assetsUrl.'galleries/',
            'coverImagePath' => $assetsPath.'covers/',
            'coverImageUrl' => $assetsUrl.'covers/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'imagesUrl' => $assetsUrl.'images/',
            'assetsUrl' => $assetsUrl,
            'jqueryFile' => 'jquery-1.7.2.min.js',
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);
		
        $this->modx->addPackage('sekusergalleries',$this->config['modelPath']);
		
		if ($this->modx->lexicon) {
            $this->modx->lexicon->load('sekusergalleries:default');
        }
    }
	
	public function getChunk($name,$properties = array()) {
		$chunk = null;
		if (!isset($this->chunks[$name])) {
			$chunk = $this->_getTplChunk($name);
			if (empty($chunk)) {
				$chunk = $this->modx->getObject('modChunk',array('name' => $name));
				if ($chunk == false) return false;
			}
			$this->chunks[$name] = $chunk->getContent();
		} else {
			$o = $this->chunks[$name];
			$chunk = $this->modx->newObject('modChunk');
			$chunk->setContent($o);
		}
		$chunk->setCacheable(false);
		return $chunk->process($properties);
	}
	 
	private function _getTplChunk($name,$postfix = '.chunk.tpl') {
		$chunk = false;
		$f = $this->config['chunksPath'].strtolower($name).$postfix;
		if (file_exists($f)) {
			$o = file_get_contents($f);
			$chunk = $this->modx->newObject('modChunk');
			$chunk->set('name',$name);
			$chunk->setContent($o);
		}
		return $chunk;
	}

    /**
     * Load the appropriate controller
     * @param string $controller
     * @return null|sekugController
     */
    public function loadController($controller) {
        if ($this->modx->loadClass('sekugController',$this->config['modelPath'].'sekusergalleries/',true,true)) {
            $classPath = $this->config['controllersPath'].'web/'.strtolower($controller).'.class.php';
            $className = 'sekug'.$controller.'Controller';
            if (file_exists($classPath)) {
                if (!class_exists($className)) {
                    $className = require_once $classPath;
                }
                if (class_exists($className)) {
                    $this->controller = new $className($this,$this->config);
                } else {
                    $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load controller: '.$className.' at '.$classPath);
                }
            } else {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load controller file: '.$classPath);
            }
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not load sekugController class.');
        }
        return $this->controller;
    }

    /**
     * Get image information
     * @param string $image_path
     * @return array
     */
    public function getImageInformation($image_path) {
        // Check if the variable is set and if the file itself exists before continuing
        if ((isset($image_path)) and (file_exists($image_path))) {
            // There are 2 arrays which contains the information we are after, so it's easier to state them both
            $exif_ifd0 = @read_exif_data($image_path ,'IFD0' ,0);
            $exif_exif = @read_exif_data($image_path ,'EXIF' ,0);
            //error control
            $notFound = "Unavailable";
            // Make
            if (@array_key_exists('Make', $exif_ifd0)) {
                $camMake = $exif_ifd0['Make'];
            } else {
                $camMake = $notFound;
            }
            // Model
            if (@array_key_exists('Model', $exif_ifd0)) {
                $camModel = $exif_ifd0['Model'];
            } else {
                $camModel = $notFound;
            }
            // Exposure
            if (@array_key_exists('ExposureTime', $exif_ifd0)) {
                $camExposure = $exif_ifd0['ExposureTime'];
            } else {
                $camExposure = $notFound;
            }
            // Aperture
            if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
                $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
            } else {
                $camAperture = $notFound;
            }
            // Date
            if (@array_key_exists('DateTime', $exif_ifd0)) {
                $camDate = $exif_ifd0['DateTime'];
            } else {
                $camDate = $notFound;
            }
            // ISO
            if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
                $camIso = $exif_exif['ISOSpeedRatings'];
            } else {
                $camIso = $notFound;
            }
            $return = array();
            $return['make'] = $camMake;
            $return['model'] = $camModel;
            $return['exposure'] = $camExposure;
            $return['aperture'] = $camAperture;
            $return['date'] = $camDate;
            $return['iso'] = $camIso;
        } else {
            return false;
        }
        return $return;
    }

    /**
     * Clean a string of tags and XSS attempts
     * 
     * @param string $body The string to clean
     * @param array $scriptProperties An array of options
     * @return string The cleansed text
     */
    public function cleanse($body,array $scriptProperties = array()) {
        $allowedTags = $this->modx->getOption('sekusergalleries.allowed_tags',$scriptProperties,'<br><b><i>');

        /* strip tags */
        $body = preg_replace("/<script(.*)<\/script>/i",'',$body);
        $body = preg_replace("/<iframe(.*)<\/iframe>/i",'',$body);
        $body = preg_replace("/<iframe(.*)\/>/i",'',$body);
        $body = strip_tags($body,$allowedTags);
        // this causes double quotes on a href tags; commenting out for now
        //$body = str_replace(array('"',"'"),array('&quot;','&apos;'),$body);
        /* replace MODx tags with entities */
        $body = str_replace(array('[',']'),array('&#91;','&#93;'),$body);

        return $body;
    }

}