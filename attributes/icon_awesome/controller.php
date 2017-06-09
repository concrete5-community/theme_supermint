<?php
namespace Concrete\Package\ThemeSupermint\Attribute\IconAwesome;

defined('C5_EXECUTE') or die(_("Access Denied."));

use Loader;
use \Concrete\Core\Attribute\DefaultController;
use \Concrete\Core\Asset\AssetList;
use Concrete\Core\Asset\Asset;
use Less_Parser;
use Less_Tree_Rule;
use Core;
use Concrete\Core\Http\ResponseAssetGroup;
use \Concrete\Package\ThemeSupermint\Controller\Tools\AwesomeArray;

class Controller extends DefaultController  {

    public function on_start() {
 		$al = AssetList::getInstance();
 		$al->register( 'javascript', 'chosen-icon', 'js/chosenIcon.jquery.js', array('version' => '1.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), 'theme_supermint' );
 		$al->register( 'javascript', 'chosen.jquery.min', 'js/chosen.jquery.min.js', array('version' => '1.4.2', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), 'theme_supermint' );
 		$al->register( 'css', 'chosenicon', 'css/chosenicon.css', array('version' => '1.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => true, 'combine' => true), 'theme_supermint' );
 		$al->register( 'css', 'chosen.min', 'css/chosen.min.css', array('version' => '1.4.2', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => true, 'combine' => true), 'theme_supermint' );
    }

	public function form() {

		$r = ResponseAssetGroup::get();
		$r->requireAsset('javascript', 'chosen.jquery.min');
		$r->requireAsset('javascript', 'chosen-icon');
		$r->requireAsset('css', 'chosen.min');
		$r->requireAsset('css', 'chosenicon');

		$icons = AwesomeArray::getAwesomeArray();
		$inputname = $this->field('value');

		if (is_object($this->attributeValue)) {
			$selected = $this->getAttributeValue()->getValue();
		} else {
			$selected = 0;
		}

		if (count($icons)):

			echo "<select name=\"$inputname\" class=\"chosenicon\">";
			foreach ($icons as $handle => $name) :
					echo "<option value=\"$handle\" data-icon=\"$handle\"" . ($selected == $handle ? ' selected ' : '') . ">$name</option>";
			endforeach;
			echo '</select>';
			echo '<script>$("document").ready(function(){$(".chosenicon").chosenIcon({width: "95%"});});</script>';
		else :
			echo t('No Icons found.');
		endif;

	}



}
