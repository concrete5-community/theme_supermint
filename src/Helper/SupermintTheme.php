<?php
namespace Concrete\Package\ThemeSupermint\Src\Helper;
use stdClass;

defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Supermint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Package;
use Loader;

class SupermintTheme {

	function get_footer_geometry ($footer_column) {
		$footer_column = $footer_column ? $footer_column : 3;
		$geometry = array();

		if (is_numeric($footer_column)) :
			for ($i = 1 ; $i < ((int)$footer_column + 1) ; $i++) :
				$geometry[$i] = array();
				$geometry[$i]['class'] = 'footer-item col-md-' . (12 / $footer_column );
				$geometry[$i]['name'] = 'Footer 0' . $i ;
			endfor;
		else :
			switch($footer_column) :

				case 'half_two':
					$geometry[1] = array('class'=>'footer-item col-md-6', 'name'=>'Footer 01');
					$geometry[2] = array('class'=>'footer-item col-md-3', 'name'=>'Footer 02');
					$geometry[3] = array('class'=>'footer-item col-md-3 last', 'name'=>'Footer 03');
					break;

				case 'half_three':
					$geometry[1] = array('class'=>'footer-item col-md-6', 'name'=>'Footer 01');
					$geometry[2] = array('class'=>'footer-item col-md-2', 'name'=>'Footer 02');
					$geometry[3] = array('class'=>'footer-item col-md-2', 'name'=>'Footer 03');
					$geometry[4] = array('class'=>'footer-item col-md-2 last', 'name'=>'Footer 04');
					break;
			endswitch;

		endif;

		return $geometry;
	}

	function createLayout ($navItems, $niKey, $break_columns_on_child, $nav_multicolumns_item_per_column){

		// Cette fonction crée un layout pour le systeme de multicolonnes

		$item_count = 0;
		$columns = 0;
		$layout = array();

		foreach ($navItems as $key => $ni)  :
			// Si on est AVANT les sous menu, on ignore
		 	if($key <= $niKey ) continue;
		 	// Si on est APRES les sous menu, on arrete.
			if($ni->level == 1 ) break;
			if ($break_columns_on_child && $ni->hasSubmenu ) {
				$columns ++;
				$item_count = 0;
			}

			if(!$break_columns_on_child && $item_count ==  $nav_multicolumns_item_per_column) {
				$columns ++;
				$item_count = 0;
			}

			$layout[$columns][] = $ni;
			$item_count ++;
		endforeach;


		if($columns) :
			return $layout;
		else :
			// Si le layout a ete cree et qu'il n'y a qu'une colonne
			// On teste le nombre d'elment pour voir si c'est normal qu'il n'y ai qu'une colonne.
			// On est soit dans le cas ou il n'y a pas plusieurs enfants pour creer des colonnes
			// et alors on se base sur uen decoupe de colonnes suivant le nombres d'elements
			if (count($layout[0]) > $nav_multicolumns_item_per_column ) return $this->createLayout($navItems,$niKey, false, $nav_multicolumns_item_per_column);
			return $layout;
		endif;
	}

	function getClassSettingsObject ($block, $defaultColumns = 3, $defaultMargin = 10  ) {
		$styleObject = new StdClass();

		if (is_object($style = $block->getCustomStyle())) :
			// We get string as 'first-class second-class'
			$classes = $style->getStyleSet()->getCustomClass();
			// And get array with each classes : 0=>'first-class', 1=>'second-class'
			$classesArray = explode(' ', $classes);

			// get Columns number
			preg_match("/(\d)-column/",$classes,$columns);
			$styleObject->columns = isset($columns[1]) ? (int)$columns[1] : (int)$defaultColumns;
			// Get margin number
			// If columns == 1 then we set margin to 0
			// If more columns, set margin to asked or to default.
			preg_match("/carousel-margin-(\d+)/",$classes,$margin);
			$styleObject->margin = $styleObject->columns > 1 ? (isset($margin[1]) ? (int)$margin[1] : (int)$defaultMargin ) : 0 ;
			// Get the 'no-text' class
			// The title is displayed by default
			$styleObject->displayTitle = array_search('no-text',$classesArray) === false;
		else :
			$styleObject->columns = (int)$defaultColumns;
			$styleObject->margin = (int)$defaultMargin;	
		endif;

		return $styleObject;

	}

}
