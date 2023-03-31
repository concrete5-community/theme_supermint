<?php 
namespace Concrete\Package\ThemeSupermint\Src\Models;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Package\PackageService;
use Loader;
use Config;
use Package;
use DOMDocument;
use Page;
use stdClass;

use \Concrete\Package\ThemeSupermint\Src\Helper\ThemeFile as ThemeFileHelper;
use \Concrete\Package\ThemeSupermint\Src\Helper\SmArrayToXml;
use \Concrete\Package\ThemeSupermint\Src\Helper\SmXmlToArray ;
use Concrete\Core\Application\Application;
use Concrete\Core\Entity\Package as PackageEntity;

class ThemeSupermintOptions implements ApplicationAwareInterface
 {
 	use ApplicationAwareTrait;

 	protected PackageEntity $pkg;

 	protected int $pID;

	function __construct (Application $app) {
		$this->setApplication($app);
		$this->init();
	}

	public static function get () {
		$session = app('session');
		return $session->get('supermint.options');
	}

	protected function init (): void
	{
		$this->pkg = $this->app[PackageService::class]->getByHandle("theme_supermint");
		$this->pID = $this->getActivePID();
	}

	public function getPresetsList() {
		$all = $this->app[Connection::class]->fetchAll("SELECT pID, name FROM SupermintOptionsPreset");
		if(is_array($all)) return $all; else return false;
	}
	public function getPresetById ($pID)
    {
		$row = $this->app[Connection::class]->executeQuery("SELECT pID, name FROM SupermintOptionsPreset WHERE pID=?", [$pID])->fetchAllAssociative();
		if(is_array($row)) {
            return $row[0];
        }
		return false;
	}

	function getPresetIdFromHandle ($pHandle)
    {
		$row = $this->app[Connection::class]->executeQuery("SELECT pID FROM SupermintOptionsPreset WHERE name=?", [$pHandle]);
		if(isset($row['pID'])) {
            return (int)$row['pID'];
        }
        return false;
	}

	function outputPresetsList ($selected=null, $name = 'preset_id', $before = [])
    {

		$list = $this->getPresetsList();
        if (!$list) {
            return false;
        }
        $r[] = '<select name="' . $name . '" id="' . $name . '" class="form-control ' . $name . '">';
        if (count($before)) :
            foreach($before as $k=>$option ) :
                $r[] = '<option value="' . -($k) . '">' . $option . '</option>';
            endforeach;
        endif;
        $default_pID = $this->getDefaultPID();
        foreach($list as $k=>$p) :

            $text = ($p['pID'] == $default_pID) ? t(' (default)') : '' ;
            $select = ($p['pID'] == $selected ) ? 'selected' : '';

            $r[] = "<option value='{$p['pID']}' $select >{$p['name']}$text</option>";

        endforeach;

        $r[] = '</select>';
        $r = implode("\r" , $r);

        return $r;
	}

	public function update()
    {
	}

	function savePreset($name, $based_on = false, $active = false, $returnID = false)
    {
        $connection = $this->app[Connection::class];
        $connection->query("INSERT INTO SupermintOptionsPreset (name,active) VALUES (?,?)", [$name, $active ? 1 : 0]);

		if ($returnID) return  $connection->lastInsertId();
		if ($based_on) :
			// Recupere le nouvel ID
			$pID = $connection->lastInsertId();
			// Duplique toutes les options qui ont comme presetID $based_on et leur donne un nouvel ID base sur celui qui vient d'etre cr��
            $connection->query("INSERT INTO SupermintOptions (option_key, option_value, pID)
					  SELECT option_key, option_value, ?
					  FROM SupermintOptions
					  WHERE pID=?",
					  array($pID, $based_on ));
		endif;

	}

	function deletePreset ($pID)
    {
        $connection = $this->app[Connection::class];
        $connection->query("DELETE SupermintOptions FROM SupermintOptions WHERE pID = ?", [$pID]);
        $connection->query("DELETE SupermintOptionsPreset FROM  SupermintOptionsPreset WHERE pID = ?", [$pID]);

		if ($pID == $this->getDefaultPID()) $this->setDefaultPID(1);

	}

	function rename_preset ($name, $pID) {
        $this->app[Connection::class]->executeQuery("UPDATE SupermintOptionsPreset
				 SET name = ?
				 WHERE pID = ?",
				 [$name, $pID]);

	}

	function setDefaultPID ($pID) {
	    $config = $this->app['config'];
        $config->save('concrete.misc.default_supermint_preset_id', $pID);
	}

	function getDefaultPID () {
        $config = $this->app['config'];
		return $config->get('concrete.misc.default_supermint_preset_id');
	}

	function getDefaultPresetTitle() {
	    if ($p = $this->getPresetById($this->getDefaultPID())) {
            return $p['name'];
        }
		return '';
	}

	function getPresetTitle($pID) {
		if ($p = $this->getPresetById($pID)) {
            return $p['name'];
        }
		return '';
	}

	protected function getActivePID ($c = null)
    {
		if (isset($_GET['pID'])){
            return $_GET['pID'];
        }
		// On regarde quel objet page prendre
		$page = $c ? $c : Page::getCurrentPage();
		// On tente de re�cup�rer la valeur de l'attribut
        $cpID = null;
		if (is_object($page)) {
            if (get_class($page) == 'Concrete\Core\Page\Page') {
                $cpID = $page->getAttribute('supermint_theme_preset_options');
            }
        }
		// On retourne la valeur de l'attribut, sinon le preset par d�fault
		return $cpID ? $cpID : $this->getDefaultPID();
	}

	/*******************************
	 * Options
	 * *****************************/

	public static function getOptionsFromPresetID ($pID) {
		$all = app(Connection::class)->fetchAll("SELECT option_key, option_value FROM SupermintOptions WHERE pID=?", [$pID]);
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

	public function getOptionsFromActivePresetID () {
		return $this->getOptionsFromPresetID($this->getActivePID());
	}

	function saveOptions ($data, $pID, $updateOnly = false) {

		foreach ($data as $k => $v):
			if ($k == 'pID') continue;
			$test = Loader::db()->GetOne("SELECT * FROM SupermintOptions WHERE option_key = ? AND pID= ?", array($k, $pID));
			if ($test):
				if ($updateOnly === false) :
					Loader::db()->update('SupermintOptions', ['option_value' => $v], ['option_key' => $k, 'pID' => $pID]);
				endif;
			 else :
				Loader::db()->executeQuery('INSERT INTO SupermintOptions(option_key, option_value, pID) VALUES(?,?,?)', [$k, $v, $pID]);
			 endif;
		endforeach;
	}

	function getXML_from_pid ($pID){

		$pkg = Package::getByHandle('theme_supermint');
		$export = array('config' =>
			array(	'theme' => $pkg->getPackageHandle(),
					'version' => $pkg->getPackageVersion(),
					'name' => $this->getPresetTitle($pID)
			));
		$export['options'] = (array)$this->getOptionsFromPresetID($pID);
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
			if(count($p['mcl_preset']) && count($p['mcl_preset']['config']) && count($p['mcl_preset']['options'])) :
				$pp = $p['mcl_preset'];
				if ($this->pkg->getPackageHandle() != $pp['config']['theme']) return array ('error' => true, 'message' => t('This preset in not compatible with this theme'));
				if (!$pID) :
					// On cree un nouveau preset et recup�re son ID
					$pID = $this->savePreset($pp['config']['name'], false, false, true);
				endif;
				// Si on a pu avoir un ID
				if ($pID) :
					// On sauve les options pour cet ID
					if ($updateOnly)
						$this->saveOptions ($pp['options'], $pID, true);
					else
						$this->saveOptions ($pp['options'], $pID, false);

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

	function updateDB () {
		$this->installDB(false,true);
	}

	function installDB ($pHandle = '', $updateOnly = false) {

		$path = Package::getByHandle('theme_supermint')->getPackagePath() . '/src/Models/theme_presets/';
		$presets_files = ThemeFileHelper::dir_walk($path , array('mcl'));

		if (is_array($presets_files) && count($presets_files)) :
			foreach ($presets_files as $p) :
				if($updateOnly) :
					$_pID = $this->getPresetIdFromHandle(str_replace('.mcl', '', $p));
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
		if ($pHandle) $pID = $this->getPresetIdFromHandle($pHandle);
	  else $pID = 1;

    // Si la function est appellé avec pHandle === false, on update, donc on ne change pas le pID actif
		if ($pID && !$updateOnly)
		  $this->setDefaultPID($pID);

	}

}