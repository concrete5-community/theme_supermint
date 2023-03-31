<?php 
namespace Concrete\Package\ThemeSupermint\Controller\Tools;

use \Concrete\Core\Controller\Controller as RouteController;
use Concrete\Core\Http\ResponseFactoryInterface;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Page;
use Loader;

class OverrideCss extends RouteController {

	function render () {
		// var_dump($_GET['pID']); die();
		$time_start = microtime(true);
		$c = Page::getByID($_GET['cID']); // Juste pour pouvoir afficher le nom de la page dans le fichier css
		$o = ThemeSupermintOptions::get();
		$option_object = new ThemeSupermintOptions(app());
		$t =  $c->getCollectionThemeObject();

		// On capte le code CSS dans le tampon
		ob_start();
	    Loader::packageElement('override.css', 'theme_supermint', array('o' => $o,
	    																 'option_object' => $option_object,
	    																 'pageTheme' => $t,
	    																 'bodypattern' => null,
	    																 'c' => $c
	    																));
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo '/* Generated Time ' . ($info ?? '') . ' : ' . $time . ' ms ' . "*/ \n\n";
		$style = ob_get_clean();

        $rf = $this->app->make(ResponseFactoryInterface::class);
        $response = $rf->create(
            $style,
            200,
            [
                'Accept-Ranges' => 'bytes',
                'Content-Type' => 'text/css',
                'Content-Length' => strlen($style),
            ]
        );

		return $response;

	}
}
