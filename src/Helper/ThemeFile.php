<?php 
namespace Concrete\Package\ThemeSupermint\Src\Helper;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @package Supermint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */


class ThemeFile {

    /**
     * Calls a function for every file in a folder.
     *
     * @author Vasil Rangelov a.k.a. boen_robot
     *
     * @param string $callback The function to call. It must accept one argument that is a relative filepath of the file.
     * @param string $dir The directory to traverse.
     * @param array $types The file types to call the function for. Leave as NULL to match all types.
     * @param bool $recursive Whether to list subfolders as well.
     * @param string $baseDir String to append at the beginning of every filepath that the callback will receive.
     */
    public static function dir_walk( $dir, $types = null, $recursive = false, $baseDir = '') {
        if ($dh = @opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                if (is_file($dir . $file)) {
                    if (is_array($types)) {
                        if (!in_array(strtolower(pathinfo($dir . $file, PATHINFO_EXTENSION)), $types, true)) {
                            continue;
                        }
                    }
                    $r[] = $file;
                }elseif($recursive && is_dir($dir . $file)) {
                    self::dir_walk( $dir . $file . DIRECTORY_SEPARATOR, $types, $recursive, $baseDir . $file . DIRECTORY_SEPARATOR);
                }
            }
            closedir($dh);
            return ($r);
        } else {
            return false ;
        }
    }
    
    function file_dir ($path, $ext ='png') {
        if ($handle = @opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (substr($entry,-3,3) == $ext) {
                        $files[substr($entry,0,-4)] = str_replace('_', ' ', ucfirst(substr($entry,0,-4)));                        
                    }
                }
            }
            closedir($handle);
            return $files;
        } else {
            return false;
            }
    }


}