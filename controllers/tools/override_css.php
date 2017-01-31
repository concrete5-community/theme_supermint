<?php
namespace Concrete\Package\ThemeSupermint\Controller\Tools;

use \Concrete\Core\Controller\Controller as RouteController;
use \Concrete\Package\ThemeSupermint\Src\Models\SupermintFont;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Page;
use Loader;

defined('C5_EXECUTE') or die(_("Access Denied."));

class OverrideCss extends RouteController {

	function render () {
		// var_dump($_GET['pID']); die();
		$time_start = microtime(true);
		$c = Page::getByID($_GET['cID']); // Juste pour pouvoir afficher le nom de la page dans le fichier css
		$o = ThemeSupermintOptions::get();
		$option_object = new ThemeSupermintOptions();
		$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);

		// On capte le code CSS dans le tampon
		ob_start();
	    Loader::packageElement('override.css', 'theme_supermint', array('o' => $o,
	    																 'option_object' => $option_object,
	    																 'pageTheme' => $t,
	    																 'bodypattern' => $bodypattern,
	    																 'c' => $c
	    																));
		$style = ob_get_clean();

		header("Content-Type: text/css");

		$time_end = microtime(true);
		$time = $time_end - $time_start;

		echo $style;
		echo '/* Generated Time ' . $info . ' : ' . $time . ' ms ' . "*/ \n\n";

	}
}
