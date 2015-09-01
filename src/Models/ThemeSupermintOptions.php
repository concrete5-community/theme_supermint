<?php
namespace Concrete\Package\ThemeSupermint\Src\Models;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Legacy\Model;
use \Concrete\Core\Foundation\Object;

use Loader;
use Config;
use Package;
use User;
use DOMDocument;
use Core;
use Page;
use stdClass;

use \Concrete\Package\ThemeSupermint\Src\Helper\ThemeFile as ThemeFileHelper;
use \Concrete\Package\ThemeSupermint\Src\Helper\SmArrayToXml;
use \Concrete\Package\ThemeSupermint\Src\Helper\SmXmlToArray ;

use \Symfony\Component\HttpFoundation\Session\Session as SymfonySession;


class ThemeSupermintOptions extends Object
 {

	var $cObj;

	function __construct ($c = null) {
		$this->init($c);
	}

	static function get () {
		$session = new \Symfony\Component\HttpFoundation\Session\Session();
		return $session->get('supermint.options');
	}

	function init ($c) {

		$this->pkg = Package::getByHandle("theme_supermint");
		$this->pID = $this->get_active_pID();

	}
	function set_collection_object($c) {
		$this->init($c);
	}
	function set_toggle_option_name($name) {
		$this->option_name = $name;
	}

	function get_presets_list() {
		$all = Loader::db()->getAll("SELECT pID, name FROM SupermintOptionsPreset");
		if(is_array($all)) return $all; else return false;
	}
	function get_preset_by_id ($pID) {
		$row = Loader::db()->getRow("SELECT pID, name FROM SupermintOptionsPreset WHERE pID=?", array($pID));
		if(is_array($row)) return $row; else return false;
	}
	function get_preset_id_from_handle ($pHandle) {
		$row = Loader::db()->getRow("SELECT pID FROM SupermintOptionsPreset WHERE name=?", array($pHandle));
		if(isset($row['pID'])) return (int)$row['pID']; else return false;
	}

	function output_presets_list ($echo = false, $selected=null, $name = 'preset_id', $before = array()) {

		$list = $this->get_presets_list ();

		if ($list) :
			$r[] = '<select name="' . $name . '" id="' . $name . '" class="form-control ' . $name . '">';
			if (count($before)) :
				foreach($before as $k=>$option ) :
					$r[] = '<option value="' . -($k) . '">' . $option . '</option>';
				endforeach;
			endif;
			$default_pID = $this->get_default_pID();
			foreach($list as $k=>$p) :

				$text = ($p['pID'] == $default_pID) ? t(' (default)') : '' ;
				$select = ($p['pID'] == $selected ) ? 'selected' : '';

				$r[] = "<option value='{$p['pID']}' $select >{$p['name']}$text</option>";

			endforeach;

			$r[] = '</select>';
			$r = implode("\r" , $r);

			if ($echo) 	echo $r;
			else return $r;

		else:
			return false;
		endif;

	}

	function update () {

	}

	function save_preset($name, $based_on = false, $active = false, $returnID = false) {

		Loader::db()->query("INSERT INTO SupermintOptionsPreset (name,active) VALUES (?,?)", array($name, $active));

		if ($returnID) return  Loader::db()->Insert_ID();
		if ($based_on) :
			// Recupere le nouvel ID
			$pID = Loader::db()->Insert_ID();
			// Duplique toutes les options qui ont comme presetID $based_on et leur donne un nouvel ID base sur celui qui vient d'etre cr��
			Loader::db()->query("INSERT INTO SupermintOptions (option_key, option_value, pID)
					  SELECT option_key, option_value, ?
					  FROM SupermintOptions
					  WHERE pID=?",
					  array($pID, $based_on ));
		endif;

	}
	function delete_preset ($pID) {
		/* Ne fonctione pas quand les options d'un preset sont vides
		Loader::db()->query("DELETE SupermintOptions, SupermintOptionsPreset
				  FROM SupermintOptions, SupermintOptionsPreset
				  WHERE SupermintOptions.pID = SupermintOptionsPreset.pID
				  AND SupermintOptionsPreset.pID = ?
				  ", array($pID));
		*/

		Loader::db()->query("DELETE SupermintOptions FROM SupermintOptions WHERE pID = ?", array($pID));
		Loader::db()->query("DELETE SupermintOptionsPreset FROM  SupermintOptionsPreset WHERE pID = ?", array($pID));

		if ($pID == $this->get_default_pID()) $this->set_default_pID(1);

	}

	function rename_preset ($name, $pID) {
		Loader::db()->query("UPDATE SupermintOptionsPreset
				 SET name = ?
				 WHERE pID = ?",
				 array( $name, $pID));

	}

	function set_default_pID ($pID) {
		Config::save('concrete.misc.default_supermint_preset_id', $pID);
	}
	function get_default_pID () {
		return Config::get('concrete.misc.default_supermint_preset_id');
	}
	function get_default_preset_title() {
		$p = $this->get_preset_by_id($this->get_default_pID());
		return $p['name'];
	}
	function get_preset_title($pID) {
		$p = $this->get_preset_by_id($pID);
		return $p['name'];
	}
	function get_active_pID ($c = null) {
		if ($_GET['pID']) return $_GET['pID'];
		// On regarde quel objet page prendre
		$page = $c ? $c : Page::getCurrentPage();
		// On tente de re�cup�rer la valeur de l'attribut
		if (is_object($page)) :
			if (get_class($page) == 'Concrete\Core\Page\Page') {
				$cpID = $page->getAttribute('supermint_theme_preset_options');
			};
		endif;
		// On retourne la valeur de l'attribut, sinon le preset par d�fault
		return $cpID ? $cpID : self::get_default_pID();
	}

	/*******************************
	 * Options
	 * *****************************/

	static function get_options_from_preset_ID ($pID) {
		$all = Loader::db()->getAll("SELECT option_key, option_value FROM SupermintOptions WHERE pID=?", array($pID));
		if(is_array($all)) {
			$r = new stdClass();
			foreach($all as $o) {
				$r->{$o['option_key']} = $o['option_value'];
			}
			$r->pID = $pID;
			return $r;
		}
		return false;
	}
	static function get_options_from_active_preset_ID () {
		return self::get_options_from_preset_ID(self::get_active_pID());
	}

	function save_options ($data, $pID, $updateOnly = false) {

		foreach ($data as $k => $v):
			if ($k == 'pID') continue;
			$test = Loader::db()->GetOne("SELECT * FROM SupermintOptions WHERE option_key = ? AND pID= ?", array($k, $pID));
			if ($test):
				if ($updateOnly === false) :
					Loader::db()->query("UPDATE SupermintOptions
							SET option_value=?
							WHERE option_key = ? AND pID= ?",
							array( $v, $k, $pID));
				endif;
			 else :
				Loader::db()->query("INSERT INTO SupermintOptions
						(option_key, option_value, pID)
						VALUES(?,?,?)
						", array( $k, $v, $pID));
			 endif;
		endforeach;
	}

	function getXML_from_pid ($pID){

		$pkg = Package::getByHandle('theme_supermint');
		$export = array('config' =>
			array(	'theme' => $pkg->getPackageHandle(),
					'version' => $pkg->getPackageVersion(),
					'name' => $this->get_preset_title($pID)
			));
		$export['options'] = (array)$this->get_options_from_preset_ID($pID);
		$exportDOM = SmArrayToXml::createXML('mcl_preset', $export);
		return $exportDOM->saveHTML();
	}

	function importXML_preset ($file, $pID = false, $updateOnly = false) {

		$content = file_get_contents($file);
		// On teste si le fichier est un XML valide
		if (!$this->is_valid_xml($content)) return array ('error' => true, 'message' => t('This is not a valid preset format'));
		// On cree un STRING du fichier qu'on envoie au transformateur
		$p = SmXmlToArray::createArray($content);
		// On tyest si on a un tableau et qu'il n'est pas vide
		if (is_array($p) && count($p)) :
			// On teste les different conteneurs
			if(count($p['mcl_preset']) && count($p['mcl_preset']['config'] && count($p['mcl_preset']['options']))) :
				$pp = $p['mcl_preset'];
				if ($this->pkg->getPackageHandle() != $pp['config']['theme']) return array ('error' => true, 'message' => t('This preset in not compatible with this theme'));
				if (!$pID) :
					// On cree un nouveau preset et recup�re son ID
					$pID = $this->save_preset($pp['config']['name'], false, false, true);
				endif;
				// Si on a pu avoir un ID
				if ($pID) :
					// On sauve les options pour cet ID
					if ($updateOnly)
						$this->save_options ($pp['options'], $pID, true);
					else
						$this->save_options ($pp['options'], $pID, false);

					return array ('error' => false, 'message' => t('Preset imported'));
				else :
					return array ('error' => true, 'message' => t('Can�t create new preset'));
				endif;
			else :
				return array ('error' => true, 'message' => t('This file seems to be not a mcl theme preset'));
			endif;
		endif;
	}

	function is_valid_xml ( $xml ) {
	    libxml_use_internal_errors( true );

	    $doc = new DOMDocument('1.0', 'utf-8');

	    $doc->loadXML( $xml );

	    $errors = libxml_get_errors();

	    return empty( $errors );
	}

	/*******************************
	 * Options Reset & install
	 * *****************************/

	function reset_options ($pID = 1) {

		$path = Package::getByHandle('theme_supermint')->getPackagePath();
		return $this->importXML_preset ($path . '/models/theme_presets/base.mcl',1);
	}

	function update_db () {
		$this->install_db(false,true);
	}

	function install_db ($pHandle = '', $updateOnly = false) {

		$path = Package::getByHandle('theme_supermint')->getPackagePath() . '/src/Models/theme_presets/';
		$presets_files = ThemeFileHelper::dir_walk($path , array('mcl'));

		if (is_array($presets_files) && count($presets_files)) :
			foreach ($presets_files as $p) :
				if($updateOnly) :
					$_pID = $this->get_preset_id_from_handle(str_replace('.mcl', '', $p));
					// On update les valeurs
					if ($_pID) $this->importXML_preset ($path . $p, $_pID, true);
					// On importe le xml
					else $this->importXML_preset ($path . $p);
				else :
					$this->importXML_preset ($path . $p);
				endif;
			endforeach;
		endif;

		// Set as default
		if ($pHandle) $pID = $this->get_preset_id_from_handle($pHandle);
	  else $pID = 1;

    // Si la function est appellé avec pHandle === false, on update, donc on ne change pas le pID actif
		if ($pID && !$updateOnly)
		  $this->set_default_pID($pID);

	}

}

?>
