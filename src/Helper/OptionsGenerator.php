<?php
namespace Concrete\Package\ThemeSupermint\Src\Helper;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Package\ThemeSupermint\Src\Helper\BaseOptionsGenerator;
use Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Core;
use Loader;

/**
 * @package Supermint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class OptionsGenerator {
	/**
	 * $options : a array of input asked
	 * $pID : ?
	 * $url : a url to a controller function that will receive the $_REQUEST
	 */
	function __construct ($options = null, $pID = null, $url = null, $url_view = null, $saved_options = null) {

		if ($options) : // Option n'est pas rempli quand il est appelle par loader::helper

			$this->poh = new ThemeSupermintOptions();
			$this->pID = $pID;
			$this->generator = new BaseOptionsGenerator($pID);
			$this->url = $url;
			$this->options = $options;
			$this->saved_options = $saved_options ? $saved_options : ThemeSupermintOptions::get_options_from_preset_ID($pID);
			$this->url_view = $url_view;
			$this->first_section = true;
			$this->render();
		endif;
	}

	function save () {

	}

	function render() {
		echo '<div class="mcl-options-wrapper" style="opacity:0">';

		$this->start();

		foreach($this->options as $option) {
			@$this->renderOption($option);
		}

		if ($this->url) echo '</form>';
		echo '</div>';
	}

	function renderOption($option){

		$option['pID'] = $this->pID;

		if (method_exists($this->generator, $option['type'])) {
			$value = isset($this->saved_options->$option['id']) ? $this->saved_options->$option['id'] : $option['default'];
			$option['value'] = $value;
			// var_dump($option);
			echo '<tr><td class="title"><strong><label for="'.$option['id'].'">' . $option['name'] . '</label></strong></td>';
			echo '<td class="desc">';
			if(isset($option['desc'])){
				echo '<p class="description">' . $option['desc'] . '</p>';
			}
			echo '</td>';
			echo '<td class="input" data-type="' . $option['type'] . '">';

			$this->generator->{$option['type']}($option);
			echo '</td></tr>';
		} elseif (method_exists($this, $option['type'])) {
			$this->{$option['type']}($option);
		}
	}


	/* -- All element that doesn't need to be wrapped in HTML -- */
	/**
	 * prints the options page title
	 */

	function start () {
		echo '<div class="mcl-options-nav">';
		// First we print the preset select
		if ($this->url_view) :
			echo '<form action="' . $this->url_view . '" method="post" id="preset_to_edit">';
			$this->poh->output_presets_list(true, $this->pID);
			echo '</form>';
		endif;
		// After Navigation into sections
		echo '<ul>';
		foreach($this->options as $option) {
			if ( $option['type'] == 'section') :
				$this->sections[] = $option;
				$href = str_replace(' ', '_',$option['name']);
				echo '<li>';
				echo '<a href="#' . $href . '" id="anchor_' . $href . '">';
				echo '<i class="fa ' . $option['icon'] . ' fa-3x"></i>';
				echo $option['name'] . '</a>';
				echo '</li>';
			endif;
		}
		echo '</ul>';
		echo '</div>';

		echo '<div class="white-background"></div>';
		if ($this->url) echo "<form method='post' action='$this->url'>";

	}
	function section ($item) {
		if (!$this->first_section) $this->closeSection();
		$this->openSection($item);
		$this->first_section = false;
	}
	function subsection ($item) {
			echo '<tr><td class="subsection" colspan="3"><h4>' . $item['name'] . '</h4>' . ( $item['desc'] ? '<p>' . $item['desc'] . '</p>' : '') . '</td></tr>';

	}
	function submit ($item) {
		$this->closeSection();
		echo '<div style="clear:both"></div>';
	    echo '<div class="ccm-dashboard-form-actions-wrapper">
	        <div class="ccm-dashboard-form-actions">
	            <button class="pull-right btn btn-success" type="submit" " name="pID" value="' . $this->pID . '" >' . $item["name"] . '</button>
	        </div>
	    </div>
    ';
	}
	function custom ($item) {
		if (method_exists($this->generator, $item['function']))
			$this->generator->$item['function']($item);
	}
	function openSection ($item) {

		echo '<div class="ccm-pane-body mcl-options-body" id="' . str_replace(' ', '_', $item['name']) . '">';
		echo '<table cellspacing="0" class="entry-form theme-options-table" style="width:100%;">';
		echo '<tbody>';
		$this->subsection ($item);

	}
	function closeSection () {
		echo '
				</tbody>
			</table>
		</div>';
	}


}
