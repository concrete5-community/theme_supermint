<?php     
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard\SupermintOptions as SmController;
use Config;
use StdClass;
use File;

class SiteSettings extends SmController {

	public function view() {
		// Config::save('concrete.white_label.logo',false);
		// Config::save('concrete.urls.background_url',false);
		// var_dump(Config::get('concrete.urls.background_url'));
		$settingsArray = array('concrete.white_label.logo','concrete.white_label.name','concrete.urls.background_url','concrete.marketplace.enabled','concrete.marketplace.intelligent_search_help','concrete.external.news_overlay', 'concrete.external.news','concrete.misc.default_jpeg_image_compression');
		$settings = new StdClass();
		foreach ($settingsArray as $setting) {			
			$handle = str_replace('.', '-', $setting);
			if ($setting == 'concrete.white_label.logo' ) :
				$fID = Config::get($setting . '_fid') ? Config::get($setting . '_fid') : 0;
				$f = File::getByID($fID);
				if (is_object($f)) :
					$settings->$handle = intval(Config::get($setting . '_fid'));
				endif;						
			// elseif ($setting == 'concrete.urls.background_url') :
			// 	$fID = Config::get($setting . '_fid') ? Config::get($setting . '_fid') : 0;

			// 	$f = File::getByID($fID);

			// 	if (is_object($f)) :
			// 		$settings->$handle = intval(Config::get($setting . '_fid'));
			// 	endif;						
			else:
			$settings->$handle = Config::get($setting);
			endif;
		}
		// var_dump($settings); die();
		$this->set('options_saved', $settings);
		parent::view();
	}

	public function save_site_settings() {
		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$_key = str_replace('-', '.', $key);
				if(strpos($key, 'concrete') === 0 ) :
					if ($_key == 'concrete.white_label.logo') :						
						$f = ($value > 0) ? File::getByID($value) : false;				  
						$path = (is_object($f)) ? $f->getVersion()->getRelativePath() : false;	
						Config::save($_key,$path);
						Config::save($_key . '_fid',$value);
					else:
					Config::save($_key,$value);
					endif;
				endif;
			}
		}
		$this->set('message', t("Settings saved"));
		$this->view();
	}

}
