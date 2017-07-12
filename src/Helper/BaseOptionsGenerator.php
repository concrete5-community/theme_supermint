<?php
namespace Concrete\Package\ThemeSupermint\Src\Helper;
use Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Loader;
use Core;
use Config;
use Less_Parser;
use Less_Tree_Rule;
use File;
/**
 * @package Supermint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

defined('C5_EXECUTE') or die("Access Denied.");

class BaseOptionsGenerator {

	var $form;
	var $pID;

	function __construct ($pID = false) {
		$this->form = Core::make('helper/form');
		$this->pID = $pID;
		$this->awesome = $this->getAwesomeArray();
	}

    protected function getAwesomeArray ()
    {
        $iconLessFile = DIR_BASE_CORE . '/css/build/vendor/font-awesome/variables.less';
        $icons = array();
        $txt = Core::make('helper/text');

        $l = new Less_Parser();
        $parser = $l->parseFile($iconLessFile, false, true);
        $rules = $parser->rules;
        // print_r($rules);
        foreach ($rules as $rule) {
            if ($rule instanceof Less_Tree_Rule) {
            	// $v = $rule->value->value[0]->value[0]->value;
            	// if(is_string($v)) {
            	// 	$unicode =  (strpos($v, '\\') === 0) ? str_replace('\\', '&#x', $v) : '';
            	// }
                if (strpos($rule->name, '@fa-var') === 0) {
                    $name = str_replace('@fa-var-', 'fa-', $rule->name);
                    $icons[$name] = $txt->unhandle($name);
                }
            }
        }
        // die();
        return $icons;
    }

	/* --- INPUTS --- */

	function text($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"size" => "10",
			"class"=> "",
		), $item));
		$class = $class?' class="'.$class.'"':'';

		echo "<input type='text' name='$id' size='$size' value='$value' class='$class' />";

	}

	function textarea($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"rows" => "7",
			"cols" => "10",
			"class"=> "code",
		), $item));
		$class = $class?' class="'.$class.'"':'';

		echo "<textarea name='$id' id='$id' cols='$cols' rows='$rows' class='$class' style='width:100%; font-family: Monaco, monospace;'>$value</textarea>";
	}

	function select($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"chosen" => false,
			"target" => NULL,
			"options" => array(),
			"class"=> "",
		), $item));

		echo $this->form->select($id,$options,$value);
	}

	function range($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"min" => NULL,
			"max" => NULL,
			"step" => NULL,
			"unit" => NULL,
		), $item));
		// echo '<input type="range" min="0" max="10" step="1" value="0">'
		echo '<div class="ui-slider-wrapper"><div id="ui-slider-' . $id . '" data-rel="' . $id . '" class="ui-slider"';
		// echo '<div class="range-input-wrap" ><input name="' . $id . '" id="' . $id . '" type="range" value="'.$value;

		if (!is_null($min)) {
			echo ' data-min="' . $min .'"';
		}
		if (!is_null($max)) {
			echo ' data-max="' . $max .'"';
		}
		if (!is_null($step)) {
			echo ' data-step="' . $step .'"';
		}
		echo '></div>';
		echo '<div class="mesure"><input type="text" name="' . $id . '" id="' . $id . '" value="' . $value . '" class="ui-slider-input" readonly />';

		if (!is_null($unit)) {
			echo '<span class="unit">' . $unit . '</span>';
		}
		echo '</div>';
		echo '</div>';

	}

	/**
	 * displays a color input
	 */
	function color($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"size" => "10",
			"class" => "",
		), $item));

		$class = $class?' class="'.$class.'"':'';

		echo '<div class="color-input-wrap"><input'.$class.' name="' . $id . '" id="' . $id . '" type="color" data-hex="true" size="' . $size . '" value="' . $value . '" /></div>';

	}

	/**
	 * displays a toggle button
	 */
	function toggle($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => null,
		), $item));

		echo '<div class="toggle-wrapper"><div class="toggle ' . ($value ? 'toggle-on' : '') . '">
				<input type="hidden" name="' . $id . '" value="' . $value . '"/>
				<div class="toggle-text-off">OFF</div>
				<div class="toggle-button"></div>
				<div class="toggle-text-on">ON</div>
			</div></div>';
	}

	function awesome($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => null,
		), $item));
		if (count($this->awesome)):

			echo "<select name=\"$id\" class=\"chosenicon\">";
			foreach ($this->awesome as $handle => $name) :
					echo "<option value=\"$handle\" data-icon=\"$handle\"" . ($value == $handle ? ' selected ' : '') . ">$name</option>";
			endforeach;
			echo '</select>';
			echo '<script>$("document").ready(function(){$(".chosenicon").chosenIcon({width: "95%"});});</script>';
		else :
			echo t('No Icons found.');
		endif;
	}

	/**
	 * displays a page selector
	 */
	function page($item) {
		extract($this->option_atts(array(
			"id" => "",
			"value" => false,
			"quick"=> false
		), $item));

		$sph = Core::make('helper/form/page_selector');
		if ($quick) :
			echo  $sph->quickSelect($id, $value); // prints out the home page and makes it selectable.
		else :
			echo  $sph->selectPage($id, $value); // prints out the home page and makes it selectable.
		endif;
	}
	/**
	 * displays a file selector
	 */
	function file($item) {
		extract($this->option_atts(array(
			"name"=>t('Choose File'),
			"id" => "",
			"value" => false,
			"filetype"=> false // image video text audio doc app
		), $item));
		// var_dump($value); die();
		$value = ($value && $value > 0) ?  File::getByID($value) : false ;


		$al = Core::make('helper/concrete/asset_library');

		if (!$filetype) :
			echo  $al->file($id, $id, $name, $value);
		else :
			echo  $al->$filetype($id, $id, $name, $value);
		endif;
	}

	/**
	 * displays a font chooser
	 */
	function font($item) {
		extract($this->option_atts(array(
			"name" => "",
			"desc" => "",
			"id" => "",
			"default" => "",
			"value" => "",
			"variantType" => "multiple",
		), $item));

		$options =  ThemeSupermintOptions::get_options_from_preset_ID($this->pID);
		$fontList = json_decode(Core::make('helper/file')->getContents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAsT5OzRSuWghytRLmwLagJ4BCl49qC1kM'));
		if (!$fontList) :
			// Si nous n'avaons pas pu recurérer le fichier, on charge celui prechargé.
			$fontList = json_decode(Core::make('helper/file')->getContents(__DIR__ . '/../../js/webfonts.json'));
		endif;
		if (!$fontList)	echo '<p>' . t('Sorry we can\'t connect to Google Fonts, perhaps you are not connected to Internet ?') . '<p>';
		// Il n'y a pas encore de gestion d'erreur
				// var_dump($options); die();

		/*
		 * p_subset
		 * p_font
		 * p_variants
		 *
		*/

		$fontName = $id . '_font';
		$subsetName = $id . '_subset';
		$variantName = $id . '_variants';
		$defaultVariantName = $variantName . '_selected';
		// La police choisie pour ce preset (si il y en a une)
		$choose = str_replace('+', ' ', $options->$fontName);
		$choose = ($choose === '0' || $choose == '') ? str_replace('+', ' ', $default) : $choose;

		$selected_variants = explode(',', $options->$variantName);
		$selected_subsets = explode(',', $options->$subsetName);
		$default_variant = 	$options->$defaultVariantName ? $options->$defaultVariantName : false;
		// Si rien n'a encore été seleciotnné
		if (! $options->$variantName ) $selected_variants[0] = 'regular';
		if (! $options->$subsetName ) $selected_subsets[0] = 'latin' ;

		echo '<tr><td class="font-title"><strong><label for="'.$id.'">' . $name . '</label></strong>';
		if(isset($desc)){
			echo '<p class="description">' . $desc . '</p>';
		}
		echo '<select name="' . $fontName . '" data-placeholder="' . t('Choose a Font...') . '" class="font_selector chzn-select" id="' . $fontName . '" data-subset="' . $subsetName . '" data-variant="' . $variantName . '" data-variantype="' . $variantType . '">';
		echo '<option value="0">' . t('- Theme default font -') . '</option>';
		// On tourne dans toutes les polices (320)
		foreach ($fontList->items as $key => $fontObj) :
			$selected = $fontObj->family == $choose  ? 'selected' : false;
			// Si une police à déjà été chargé pour cette option, on retient ses infos
			// Pour les details
			if ($selected) {
				$variants = $fontObj->variants;
				$subsets = $fontObj->subsets;
			}
			echo '<option value="' . str_replace(' ', '+', $fontObj->family) . '" ' . $selected . '>' . $fontObj->family . '</option>';
		endforeach;
		echo '</select>';
		echo '</td>';
		echo '<td class="font-input" data-type="' . $function . '">';



		// La boit a infos
		echo '<div id="' . $fontName . '_details_wrapper" class="font_details">';
			// Si il y a des infos chargées, on remplis la boite
			if ($variants || $subsets) Loader::packageElement('font_details','theme_supermint',array(
				// Le type d'input
				'variantType' => $variantType,
				// La police choisie
				'font' => $choose,
				// Les tableaux des options disponibles
				'variants' => $variants,
				'subsets' => $subsets,
				// LE nom des inputs
				'subsetName' => $subsetName,
				'variantName' => $variantName,
				// Les options selectionee
				'selected_subsets' => $selected_subsets,
				'selected_variants' => $selected_variants,
				'default_variant' => $default_variant

				));
		echo '</div>';
	echo '</td></tr>';
	}

	function option_atts ($pairs, $atts){
		$atts = (array)$atts;
		$out = array();
		foreach($pairs as $name => $default) {
			if ( array_key_exists($name, $atts) )
				$out[$name] = $atts[$name];
			else
				$out[$name] = $default;
		}
		return $out;
	}
}
