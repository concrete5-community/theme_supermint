<?php 
namespace Concrete\Package\ThemeSupermint\Controller\Tools;

use \Concrete\Core\Controller\Controller as RouteController;
use Loader;
use Less_Parser;
use Less_Cache;
use Less_Tree_Rule;
use StdClass;
use Core;

defined('C5_EXECUTE') or die(_("Access Denied."));

class AwesomeArray extends RouteController {		

    function getAwesomeArray ()
    {
        $iconLessFile = DIR_BASE_CORE . '/css/build/vendor/font-awesome/variables.less';
        $icons = array();
        $txt = Core::make('helper/text');

        $l = new Less_Parser();
        $parser = $l->parseFile($iconLessFile, false, true);
        $rules = $parser->rules;
        foreach ($rules as $rule) {
            if ($rule instanceof Less_Tree_Rule) {
                if (strpos($rule->name, '@fa-var') === 0) {
                    $name = str_replace('@fa-var-', 'fa-', $rule->name);
                    $icons[$name] = $txt->unhandle($name);
                }
            }
        }
        if ($_REQUEST['isJson'])
            echo json_encode($icons);
        else
            return $icons;     
    } 
}
