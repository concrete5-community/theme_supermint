<?php     
namespace Concrete\Package\ThemeSupermint\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Concrete\Package\ThemeSupermint\Src\Helper\ThemeFile;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Package;

class SupermintOptions extends DashboardPageController
{
    protected array $jsFiles = [];
    protected array $cssFiles = [];

    protected ThemeSupermintOptions $themeSupermintOptions;

	function on_start () {
	    parent::on_start();
		$pkg = Package::getByHandle('theme_supermint');
		$path = $pkg->getPackagePath();
		$js_files = ThemeFile::dir_walk($path . '/js/', array('js'));
		$css_files = ThemeFile::dir_walk($path . '/css/', array('css'));

		$this->themeSupermintOptions = $this->app->make(ThemeSupermintOptions::class);
				
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
		
		//$this->requireAsset('select2');

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

		$this->set('post', $_POST);
		if ($this->c->getCollectionPath() == '/dashboard/supermint_options') $this->redirect('/dashboard/supermint_options/theme_options');

		$this->set('poh', $this->themeSupermintOptions);
		
		if 	(isset($_POST['preset_id']) ) :
				$this->set('pID', $_POST['preset_id']);
		elseif 	(isset($_POST['pID']) ) :
				$this->set('pID', $_POST['pID']);
		else :
				$this->set('pID', $this->themeSupermintOptions->getDefaultPID());
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
            $this->themeSupermintOptions->saveOptions($data, $pID);
			$this->set('message', t('Options saved !'));
			$this->view();
		else :
			$this->view();		
		endif;

	}
}