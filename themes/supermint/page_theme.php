<?php
namespace Concrete\Package\ThemeSupermint\Theme\Supermint;
use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use stdClass;
use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Package;
use Loader;
use CollectionAttributeKey;

defined('C5_EXECUTE') or die('Access Denied.');

// Ready For 5.7.5
// class PageTheme extends \Concrete\Core\Page\Theme\Theme implements ThemeProviderInterface {

class PageTheme extends \Concrete\Core\Page\Theme\Theme {

    protected $pThemeGridFrameworkHandle = 'bootstrap3';


	public function registerAssets() {

        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('core/lightbox');
        $this->requireAsset('javascript', 'backstretch');
        $this->requireAsset('javascript', 'bootstrap/alert');

        $this->requireAsset('javascript', 'mmenu');
        $this->requireAsset('javascript', 'boxnav');
        $this->requireAsset('javascript', 'modernizr.custom');
        $this->requireAsset('javascript', 'wow');
        $this->requireAsset('javascript', 'rcrumbs');
        $this->requireAsset('javascript', 'nprogress');
        $this->requireAsset('javascript', 'slick');
        $this->requireAsset('javascript', 'autohidingnavbar');
        $this->requireAsset('javascript', 'YTPlayer');
        $this->requireAsset('javascript', 'transit');
        $this->requireAsset('javascript', 'isotope');
        $this->requireAsset('javascript', 'harmonize-text');
        $this->requireAsset('javascript', 'enquire');
        $this->requireAsset('javascript', 'supermint.script');

        // $this->requireAsset('javascript', 'fontcolor');

        $this->requireAsset('css', 'font-awesome');
        $this->requireAsset('css', 'YTPlayer');
        $this->requireAsset('css', 'slick');
        $this->requireAsset('css', 'mmenu');
        $this->requireAsset('css', 'bootsrap-custom');
        $this->requireAsset('css', 'mega-menu');
        $this->requireAsset('css', 'transit');
        $this->requireAsset('css', 'animate');
        $this->requireAsset('css', 'overrides');

	}

    public function getThemeName()
    {
        return t('Supermint');
    }

    public function getThemeDescription()
    {
        return t('A very clean and responsive theme for Concrete5');
    }

    public function getThemeBlockClasses()
    {

        $blocks_classes = array('block-primary', 'block-secondary', 'block-tertiary', 'block-quaternary');
        $columns = $margin = array();
        for ($i=1; $i < 7; $i++) $columnsClasses[] = "$i-column";
        for ($i=0; $i < 40; $i+=10) $marginClasses[] =  "carousel-margin-{$i}px";

        return array(
            // 'page_list' => array('simple'),
            'feature' => array('icon-m','icon-l','icon-xl'),
            'content' => array('image-caption','image-caption-inside','collapse-top-margin'),
            'autonav' => array('small-text-size','contain-width'),
            'horizontal_rule' => array('space-s','space-m','space-l','space-xl','primary','secondary','tertiary','quaternary'),
            'testimonial' => array ('primary','secondary','tertiary','quaternary','white'),
                              // Smoked classes
            'image' => array('black-smoked','primary-smoked','secondary-smoked','tertiary-smoked','quaternary-smoked', 'white-smoked',
                             'no-text',
                              // Height classes
                             'height-80','height-50','height-30',
                             'into-columns',
                             // Caption  classes
                             'caption-inside','caption-hover',
                             'caption-primary', 'caption-secondary', 'caption-tertiary', 'caption-quaternary'),
            'image_slider' =>array_merge(array('into-columns','black-smoked','primary-smoked','secondary-smoked','tertiary-smoked','quaternary-smoked', 'white-smoked'),$columnsClasses, $marginClasses),
            'page_attribute_display' => array('leaded','lighted'),
            'page_list' => array_merge($columnsClasses,$marginClasses, array('no-gap')),
            'core_stack_display' => array_merge(array('element-primary','element-secondary','element-tertiary','element-quaternary','element-light'),$columnsClasses),
            'core_area_layout' => array('no-gap')
        );
    }

    public function getThemeAreaClasses()
    {
        // For multiple area
        $main_area = array('Main');
        $area_classes = array(
            // Colors
            'page-content-style','area-primary','area-secondary','area-tertiary','area-quaternary','area-white','area-black','area-body',
            // Spacing
            'area-space-s','area-space-m','area-space-l','area-space-xl',
            // Topics
            'topic-get-in-touch','topic-idea','topic-help','topic-config','topic-news','topic-conversation',
            // Layouts
            'lateral-wide',
            // Animation
            'wow','flipInX','fadeInDown','zoomIn'
            );
        for ($i=1; $i < 8; $i++) {
            $main_area['Main - ' . $i] = $area_classes;
            $main_area['Main Column ' . $i] = $area_classes;
            $main_area['Main Column 1 - ' . $i] = $area_classes;
            $main_area['Main Column 2 - ' . $i] = $area_classes;
            $main_area['Main Column 3 - ' . $i] = $area_classes;
            $main_area['Main Column 4 - ' . $i] = $area_classes;
        }
        // Default array
        $other_area = array(
            'Header' => $area_classes,
            'Header Content' => $area_classes,
            'Header Right' => $area_classes,
            'Header Image' => $area_classes,
            'Main' => $area_classes,
            'Main Column' => $area_classes,
            'Main Bottom' => $area_classes,
            'Page Footer' => $area_classes,
            'Sidebar Footer' => $area_classes,
            'Sidebar' => $area_classes
        );

        return array_merge($main_area,$other_area);
    }

    public function getThemeEditorClasses()
    {
        return array(
            array('title' => t('Alternate'), 'menuClass' => 'alternate', 'spanClass' => 'alternate'),
            array('title' => t('Code'), 'menuClass' => '', 'spanClass' => 'code'),
            array('title' => t('Light'), 'menuClass' => 'light', 'spanClass' => 'light'),
            array('title' => t('Small'), 'menuClass' => 'small', 'spanClass' => 'small'),
            array('title' => t('Lead'), 'menuClass' => 'lead', 'spanClass' => 'lead')
        );
    }

    public function getThemeResponsiveImageMap()
    {
        return array(
            'large' => '900px',
            'medium' => '768px',
            'small' => '0'
        );
    }

    public function getThemeAreaLayoutPresets()
    {
        $presets = array(
            array(
                'handle' => 'left_sidebar',
                'name' => 'Left Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => array(
                    '<div class="col-sm-4 sidebar sb-header"></div>',
                    '<div class="col-sm-8"></div>'
                ),
            ),
            array(
                'handle' => 'right_sidebar',
                'name' => 'Right Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => array(
                    '<div class="col-sm-8"></div>',
                    '<div class="col-sm-4 sidebar sb-header"></div>'
                )
            ),
            array(
                'handle' => 'intro_desc_breadcrumb',
                'name' => 'Intro desc. & breadcrumb',
                'container' => '<div class="row"></div>',
                'columns' => array(
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-4"></div>'
                )
            )

        );
        return $presets;
    }


  /* --- HELPERS ---- */


  public function getPageTags ($pages) {
    $tagsObject = new StdClass();
    $tagsObject->tags = $tagsObject->pageTags = array();
    $ak = CollectionAttributeKey::getByHandle('tags');
    $db = Loader::db();

    foreach ($pages as $key => $page):
    		if ($page->getAttribute('tags')) :

    				$v = array($page->getCollectionID(), $page->getVersionID(), $ak->getAttributeKeyID());
    				$avID = $db->GetOne("SELECT avID FROM collectionAttributeValues WHERE cID = ? AND cvID = ? AND akID = ?", $v);
    				if (!$avID) continue;

    				$query = $db->GetAll("
    						SELECT opt.value
    						FROM atSelectOptions opt,
    						atSelectOptionsSelected sel

    						WHERE sel.avID = ?
    						AND sel.atSelectOptionID = opt.ID",$avID);

    				foreach($query as $opt) {
    						$handle = preg_replace('/\s*/', '', strtolower($opt['value']));
    						$tagsObject->pageTags[$page->getCollectionID()][] =  $handle ;
    						$tagsObject->tags[$handle] = $opt['value'];
    				}
    		endif ;
    endforeach;
    return $tagsObject;
  }


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

		if (is_object($block) && is_object($style = $block->getCustomStyle())) :
			// We get string as 'first-class second-class'
			$classes = $style->getStyleSet()->getCustomClass();
			// And get array with each classes : 0=>'first-class', 1=>'second-class'
			$classesArray = explode(' ', $classes);
			$styleObject->classesArray = $classesArray;

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
			$styleObject->classesArray = array();
		endif;

		return $styleObject;

	}




}
