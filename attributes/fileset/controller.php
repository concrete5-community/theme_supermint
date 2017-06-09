<?php
namespace Concrete\Package\ThemeSupermint\Attribute\Fileset;

defined('C5_EXECUTE') or die(_("Access Denied."));

use Loader;
use \Concrete\Core\Attribute\DefaultController;
use FileSet;

class Controller extends DefaultController  {

	public function form() {

		$fileSets = FileSet::getMySets();
		foreach ($fileSets as $fs) :
			$input[$fs->fsID ] = htmlspecialchars($fs->fsName, ENT_QUOTES, 'UTF-8');
		endforeach;

		$name = $this->field('value');

		if (is_object($this->attributeValue)) {
			$selected = $this->getAttributeValue()->getValue();
		} else {
			$selected = 0;
		}

		if (count($input))
			print Loader::helper('form')->select($this->field('value'), $input,$selected);
		else
			echo t('No file sets found.');

	}

}
