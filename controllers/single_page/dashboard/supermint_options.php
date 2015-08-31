<?php     
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard;
// namespace Concrete\Package\Fundamental\Controller\SinglePage\Dashboard\Fundamental;
defined('C5_EXECUTE') or die(_("Access Denied."));


use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use \Concrete\Package\ThemeSupermint\Src\Helper\OptionsGenerator;
use \Concrete\Package\ThemeSupermint\Src\Helper\ThemeFile;
use \Concrete\Core\Asset\Asset;
use \Concrete\Core\Asset\AssetList;
use Loader;
use Package;


class SupermintOptions extends DashboardPageController {

	public $helpers = array('form'); 

	function on_start () {
		$pkg = Package::getByHandle('theme_supermint');
		$path = $pkg->getPackagePath();
		$js_files = ThemeFile::dir_walk($path . '/js/', array('js'));
		$css_files = ThemeFile::dir_walk($path . '/css/', array('css'));

		$this->poh = new ThemeSupermintOptions();
		
				
		// Include all js file from package/js
 		$al = AssetList::getInstance(); 


		if (is_array($js_files)) :
			foreach ($js_files as $js) :
				$name = str_replace('.js', '', $js);
				$this->jsFiles[] = $name;
				$al->register( 'javascript', $name, 'js/' . $js , array('version' => '1.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $pkg ); 
			endforeach;
		endif;
		
		// Include all css file from package/css
		if (is_array($css_files)) :
			foreach ($css_files as $css) :
				$name = str_replace('.css', '', $css);
				$this->cssFiles[] = $name;
				$al->register( 'css', $name, 'css/' . $css , array('version' => '1.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $pkg ); 
			endforeach;
		endif;		

	}


	function view() {
		
		$this->requireAsset('select2');

		if(is_array($this->jsFiles)) :
			foreach ($this->jsFiles as $name) {
		        $this->requireAsset('javascript', $name);
			}
		endif;
		if(is_array($this->cssFiles)) :
			foreach ($this->cssFiles as $name) {
		        $this->requireAsset('css', $name);
			}
		endif;

		// $this->poh = ThemeSupermintOptions::get();
		$this->set('post', $_POST);
		if ($this->c->cPath == '/dashboard/supermint_options') $this->redirect('/dashboard/supermint_options/theme_options');

		$this->set('poh', $this->poh);
		
		if 	(isset($_POST['preset_id']) ) :
				$this->set('pID', $_POST['preset_id']);
		elseif 	(isset($_POST['pID']) ) :
				$this->set('pID', $_POST['pID']);
		else :
				$this->set('pID', $this->poh->get_default_pID());
		endif;			
			
		// parent::view();		
	}
	
	function save_options ($POST = null) {

		$POST = $POST ? $POST : $this->post();
		$data = array();
		foreach ($POST as $key=>$value) :
			// echo "$key \n";
			if ($key == 'pID') :
				$pID = $value;	// get the pID of options edited
			else :
				$stringValue = is_array($value) ? implode(',', $value) : $value;
				$data[$key] = $stringValue;
			endif;
		endforeach;
		if (isset($pID)):
			$this->poh->save_options($data,$pID);
			$this->set('message', t('Options saved !'));
			$this->view();
		else :
			$this->view();		
		endif;

	}
}