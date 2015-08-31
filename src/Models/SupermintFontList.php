<?php  
namespace Concrete\Package\ThemeSupermint\Src\Models;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Legacy\Model;
use Loader;
use Concrete\Package\ThemeSupermint\Src\Models\SupermintFont as SupermintFont;

class SupermintFontList {

	var $googleUrl = "http://fonts.googleapis.com/css";
	var $subsetUrl = "subset";
	var $familyUrl = "family";

	function __construct () {
		$this->list = array();
		$this->time_start = microtime(true);
	}

	function addFont ($tag) {
		$font = new SupermintFont($tag);
		if ($font->font ):
			foreach ($font->subset as $key => $subset) {
				if ($subset)
				$this->list[$font->font]['subset'][$subset] = '';
			}
			foreach ($font->variant as $key => $variant) {
				if ($variant)
				$this->list[$font->font]['variant'][$variant] = '';
			}
		endif;
	}

	function getCssUrlFromList () {
		if (!is_array($this->list) || !count($this->list)) return;
		$str = array();
		$subsets = array();
		// On traverse otutes les fontes ajoutées à la liste
		foreach ($this->list as $font => $fontArray) {
			if (!$font) continue;
			$str[$font] = 	$font . ':' . implode(',', array_keys($fontArray['variant']));
			foreach ($fontArray['subset'] as $sub => $value) :
				$subset[$sub] = '';
			endforeach;
			
		}
		$time_end = microtime(true);
		$time = $time_end - $this->time_start;
		$str = 	$this->googleUrl .
				'?' . $this->familyUrl . '=' . implode('|', $str) . 
				'&' . $this->subsetUrl . '=' . implode(',', array_keys($subset)) .
				''; //'&generatedTime=' . $time;


		return $str;
	}

}