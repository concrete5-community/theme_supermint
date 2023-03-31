<?php     
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions;

use \Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions as SmController;

class Fonts extends SmController {


    function view() {
        
        parent::view();

                
    }

    function save_options($POST = null) {

        parent::save_options($_POST);
    }
    
}
