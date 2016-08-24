<?php     
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions as SmController;

class Fonts extends SmController {


    function view() {
        
        parent::view();

                
    }

    function save_options() {

        parent::save_options($_POST);
    }
    
}
