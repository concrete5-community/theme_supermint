<?php 
namespace Concrete\Package\ThemeSuperMint\Block\PieChart;

defined('C5_EXECUTE') or die(_("Access Denied."));

use Concrete\Core\Block\BlockController;
use Concrete\Core\Form\Service\Widget\Color;
use Loader;
use StdClass;

class Controller extends BlockController {

	protected $btTable = "btPieChart";
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "500";
    protected $btDefaultSet = 'multimedia';	


	public function getBlockTypeName() {
		return t('Flat Pie Chart');
	}

	public function getBlockTypeDescription() {
		return t('Render simple pie charts for single values. ');
	}

	
	public function add () {
		$this->setAssetEdit();

	}
	public function edit () {
		$this->setAssetEdit();
	}

    function getOptionsObject ()  { 
        // Cette fonction retourne un objet option
        // SI le block n'existe pas encore, ces options sont préréglées
        // Si il existe on transfome la chaine de charactère en json
        if (!$this->bID) :	
        	$session = new \Symfony\Component\HttpFoundation\Session\Session();
        	$colors = $session->get('supermint.colors',$colors);

        	$options = new StdClass();
			$options->value = 75;
			$options->content = '75%';
			$options->fontSize = 20;
			$options->textColor = (isset($colors->colors['black']) && $colors->colors['black']) ? $this->rgb2hex($colors->colors['black']) : '#000000';	
			$options->barColor = (isset($colors->colors['primary']) && $colors->colors['primary']) ? $this->rgb2hex($colors->colors['primary']) : '#18aedf';
			$options->trackColor = '#f2f2f2';
			$options->scaleColor = '#dfe0e0';
			$options->lineCap = 'butt';
			$options->lineWidth = 3;
			$options->rotate = 0;
			$options->animate = 0;		
			$options->size = 200;		
			$options->track = 1;		
			$options->scale = 1;
        else:
            $options = json_decode($this->options);
            if (is_object($options->options))
        		$options = $options->options;
            // legacy
            // if(!isset($options->fancyOverlay)) $options->fancyOverlay = '#f0f0f0';
            // end legacy
        endif;

        return $options ; 

    }	

    public function setAssetEdit () {
		$this->requireAsset('core/colorpicker');
		$this->requireAsset('css', 'font-awesome');
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('options', $this->getOptionsObject());  
    }
	
	public function view () {
		// var_dump($this->getOptionsObject());
        $this->set('options', $this->getOptionsObject());  

	}

    public function registerViewAssets() {
        $this->requireAsset('css', 'font-awesome');
    }

	private function set_block_tool($tool_name){
		// $urls = Loader::helper('concrete/urls');
		// $bt = BlockType::getByHandle($this->btHandle);
		// $this->set ($tool_name, $urls->getBlockTypeToolsURL($bt).'/'.$tool_name);
		$this->set ($tool_name, 'to be defined by route ?');
	}
    function rgb2hex($rgbstring) {
        
        $color = str_replace(array('rgb(', ')', ' '), '', $rgbstring);
        $rgb = explode(',', $color);        
        
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

       return $hex; // colorsObjects the hex value including the number sign (#)
    }
	public function save($data) {
        $options = $data;
        // unset($options['fID']);
        $data['options'] = json_encode($options);
		parent::save($data);

	}
    public function getImportData($blockNode, $page)
    {
        $options = json_decode(stripslashes(str_replace(
        	array('"{','}"'),
        	array('{','}'),
        	$blockNode->data->record->options)));
        if (is_object($options->options))
        	$options = $options->options;
        
        $args = array('options' => $options);

        return $args;
    }	

}
