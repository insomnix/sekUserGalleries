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

    /**
     * Retrieve information about server folders.
     */
class sekugDirectory {
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;
    /**
     * A reference to the sekUserGalleries instance
     * @var sekUserGalleries $sekug
     */
    public $sekug;
    /**
     * A configuration array
     * @var array $config
     */
    public $config = array();

    /**
     * @param sekUserGalleries $sekug
     * @param array $config
     */
    function __construct(sekUserGalleries &$sekug,array $config = array()) {
        $this->sekug =& $sekug;
        $this->modx =& $sekug->modx;
        $this->config = array_merge($this->config,$config);
    }

    /**
     * Format the bytes ino a more human friendly form
     *
     * @param int $bytes
     * @return string
     */
    public function format_bytes($bytes) {
        if ($bytes < 1024) {
            return $bytes .' B';
        } elseif ($bytes < 1048576) {
            return round($bytes / 1024, 2) .' KiB';
        } elseif ($bytes < 1073741824) {
            return round($bytes / 1048576, 2) . ' MiB';
        } elseif ($bytes < 1099511627776) {
            return round($bytes / 1073741824, 2) . ' GiB';
        } elseif ($bytes < 1125899906842624) {
            return round($bytes / 1099511627776, 2) .' TiB';
        } elseif ($bytes < 1152921504606846976) {
            return round($bytes / 1125899906842624, 2) .' PiB';
        } elseif ($bytes < 1180591620717411303424) {
            return round($bytes / 1152921504606846976, 2) .' EiB';
        } elseif ($bytes < 1208925819614629174706176) {
            return round($bytes / 1180591620717411303424, 2) .' ZiB';
        } else {
            return round($bytes / 1208925819614629174706176, 2) .' YiB';
        }
    }

    /**
     * Return the raw bytes
     *
     * @param int $size
     * @param string $format
     * @return int
     */
    public function raw_bytes($size,$format) {
        switch($format) {
            case 'KiB':
                return $size * 1024;
                break;
            case 'MiB':
                return $size * 1024 * 1024;
                break;
            case 'GiB':
                return $size * 1024 * 1024 * 1024;
                break;
            case 'TiB':
                return $size * 1024 * 1024 * 1024 * 1024;
                break;
            case 'PiB':
                return $size * 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            case 'EiB':
                return $size * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            case 'ZiB':
                return $size * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            case 'YiB':
                return $size * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            default:
                return $size;
                break;
        }
    }

    /**
     * Get the folder size of a *nix server
     *
     * @param string $path
     * @return int
     */
    function getNixDirSize($path) {
        $io = popen('/usr/bin/du -ks '.$path, 'r');
        $output = fgets ( $io, 4096);
        $result = preg_split('/\s/', $output);
        $size = $result[0]*1024;
        pclose($io);
        return $size;
    }

    /**
     * Get the folder size of a windows server
     *
     * @param string $path
     * @return int
     */
    function getWinDirSize($path) {
        $obj = new COM ( 'scripting.filesystemobject' );
        if ( is_object ( $obj ) )
        {
            $ref = $obj->getfolder ( $path );
            $dir_size = $ref->size;
            $obj = null;
            return $dir_size;
        }
    }

    /**
     * Get the folder size
     *
     * @param string $path
     * @param bool $format
     * @return int/string
     */
    public function getSpaceUsed($path,$format = false){
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //This is a server using Windows
            $output = $this->getWinDirSize($path);
        } else {
            //This is a server not using Windows
            $output = $this->getNixDirSize($path);
        }
        if($format===true){
            $output = $this->format_bytes($output);
        }
        return $output;
    }

    /**
     * Get the folder statistics
     *
     * @param string $path
     * @param int $space_allotted
     * @return array
     */
    public function getStatistics($path,$space_allotted){
        if(file_exists($path)){
            $space_used = $this->getSpaceUsed($path);
            $stats['space_used'] = $this->format_bytes( ($space_allotted < $space_used) ? $space_allotted : $space_used );
            $stats['percentage_used'] = round(($space_used / $space_allotted) * 100);
            $stats['space_allotted'] = $this->format_bytes($space_allotted);
            $stats['percentage_used'] = ($stats['percentage_used'] > 100) ? 100 : $stats['percentage_used'];
            return $stats;
        }else{
            return false;
        }
    }

    /**
     * Delete a folder and its contents
     *
     * @param string $dir
     * @return bool
     */
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
        return true;
    }

    /**
     * Get the contents of a directory in an array
     *
     * @param string $directory The path to the directory to display
     * @return array of files
     */
    public function get_directory_content($directory){
        if (is_dir( $directory )){
            $open_directory = opendir($directory);
            $files = array();
            while($file = readdir($open_directory)){
                if($file !== '.' && $file !== '..'){
                    $files[] = $file;
                }
            }
            return $files;
        }else{
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Directory does not exist: '.$directory);
            return false;
        }
    }

}