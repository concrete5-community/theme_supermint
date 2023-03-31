<?php 
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions;

use Core;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;

use \Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions as SmController;

class OptionsPresets extends SmController {

    protected ThemeSupermintOptions $themeSupermintOptions;

	function on_start()
    {
		$this->themeSupermintOptions = $this->app->make(ThemeSupermintOptions::class);
		$this->requireAsset('javascript', 'jquery');
		parent::on_start();
	}

	function view() {
		$this->set('poh', $this->themeSupermintOptions);
		$this->set('list',  $this->themeSupermintOptions->getPresetsList());
		$this->set('ih', Core::make('helper/form'));
		parent::view();
	}

	function save_preset() {
		if ($_POST['name'] != '') :
            $this->themeSupermintOptions->savePreset( htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') , $_POST['preset_id']);
			$this->set('message', t('Preset created !'));
			$this->view();
		else:
			$this->error->add(t('Error, the name is empty'));
			$this->view();
		endif;

		$this->view();
	}

	function edit_preset() {
		if ($pID = $this->retrieve_id('preset_to_delete_')) {
            $this->themeSupermintOptions->deletePreset($pID);
			$this->set('message', t('Preset deleted !'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('preset_to_rename_')) {
			if ($_POST['rename_' . $pID] == '') {
				$this->error->add(t('Error, the name is empty'));
				$this->view();
				return;
			}
            $this->themeSupermintOptions->rename_preset($_POST['rename_' . $pID] , $pID);
			$this->set('message', t('Preset renamed !'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('set_as_default_')) {
            $this->themeSupermintOptions->setDefaultPID($pID);
			$title = $this->themeSupermintOptions->getPresetTitle($pID);
			$this->set('message', t('Preset set as default'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('preset_to_reset_')) {
			$success = $this->themeSupermintOptions->reset_options($pID);
			if (!$success['error'])
				$this->set('message', 'Preset reseted with starting values');
			else
				$this->error->add('Reset error : ' . $success['message']);
			$this->view();
		}
		$this->view();

	}

	function retrieve_id ($expr) {
		$expression = '/^' . $expr . '(.+)$/';
		$unextracted_rows = array_merge(array(),preg_grep($expression, array_keys($_POST)));

        if ($unextracted_rows === []) {
            return false;
        }
		preg_match($expression, $unextracted_rows[0], $row_matches);
		return $row_matches[1];

	}

	function import_preset () {

		$uploadfile = DIR_FILES_UPLOADED_STANDARD . '/' . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			$success = $this->themeSupermintOptions->importXML_preset($uploadfile);
			if (!$success['error'])
				$this->set('message', 'Preset imported successfully');
			else
				$this->error->add('File error : ' . $success['message']);

			$this->view();


		} else {
			$this->error->add(t('Error the file doesn\'t work : ' . $uploadfile . print_r($_FILES)));
			$this->view();
		}



	}

}
