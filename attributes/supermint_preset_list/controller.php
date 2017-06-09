<?php
namespace Concrete\Package\ThemeSupermint\Attribute\SupermintPresetList;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Attribute\DefaultController;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions as ThemeSupermintOptions;
use View;

class Controller extends DefaultController  {

	public function form() {

		$name = $this->field('value');
		$poh = new ThemeSupermintOptions();


		if (is_object($this->attributeValue)) {
			$selected = $this->getAttributeValue()->getValue();
		} else {
			$selected = 0;
		}

		 $poh->output_presets_list(true, $selected, $name);
	}

}
