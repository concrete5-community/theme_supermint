<?php 
namespace Concrete\Package\ThemeSupermint\Controller\Tools;

use \Concrete\Core\Controller\Controller as RouteController;
use Loader;

defined('C5_EXECUTE') or die(_("Access Denied."));


class XmlPreset extends RouteController {
		
		function render () {
			if (!$_GET['pid']) die('No pID');
			$o = new \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions();
			$th = Loader::helper('text');
			$xmlDOM =$o->getXML_from_pid($_GET['pid']);

			header ("Content-Type:text/xml");
			header('Content-Disposition: attachment; filename="' .  $th->sanitizeFileSystem($o->get_preset_title($_GET['pid'])) . '.mcl"');

			echo $xmlDOM;
		}
}