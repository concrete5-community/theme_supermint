<?php
namespace Concrete\Package\ThemeSupermint\Theme\Supermint;

use \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions;
use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use stdClass;
use Package;
use Loader;
use Core;
use Page;
use Request;
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
        $this->requireAsset('javascript', 'imageloaded');
        $this->requireAsset('javascript', 'isotope');
        $this->requireAsset('javascript', 'element-masonry');
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

    public function getOptions() {
      return ThemeSupermintOptions::get();
    }

    public function getThemeBlockClasses()
    {

        $blocks_classes = array('block-primary', 'block-secondary', 'block-tertiary', 'block-quaternary');
        $columns = $margin = array();
        for ($i=1; $i < 7; $i++) $columnsClasses[] = "$i-column";

        return array(
            // 'page_list' => array('simple'),
            'feature' => array('icon-size-m','icon-size-l','icon-size-xl'),
            'content' => array('image-caption','image-caption-inside','collapse-top-margin'),
            'autonav' => array('small-text-size','contain-width'),
            'horizontal_rule' => array('space-s','space-m','space-l','space-xl','primary','secondary','tertiary','quaternary'),
            'testimonial' => array ('primary','secondary','tertiary','quaternary','white'),
                              // Smoked classes
            'image' => array('image-center',
                              // Colored classes
                             'black-smoked','primary-smoked','secondary-smoked','tertiary-smoked','quaternary-smoked', 'white-smoked',
                             // Don't display title and desc overlay on some templates
                             'no-text',
                              // Height classes
                             'height-80','height-50','height-30',
                             // Cancel the container width to display the block into small area.
                             'into-columns',
                             // Caption  classes
                             'caption-inside','caption-hover',
                             'caption-primary', 'caption-secondary', 'caption-tertiary', 'caption-quaternary'),
            'page_list' => array_merge(
                            $columnsClasses,
                            array(
                              // page-list type
              								'is-masonry','is-carousel',
              								// Sorting
              								'tag-sorting','keyword-sorting',
              								// Popup result
              								'popup-link',
              								// Layout
              								'no-gap'
                            )),
            'image_slider' =>array_merge(array('into-columns','black-smoked','primary-smoked','secondary-smoked','tertiary-smoked','quaternary-smoked', 'white-smoked'),$columnsClasses),
            'page_attribute_display' => array('leaded','lighted'),
            'core_stack_display' => array_merge(array('element-primary','element-secondary','element-tertiary','element-quaternary','element-light','open-0','open-1','open-2'),$columnsClasses),
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
            'large' => '1500px',
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


  public function getPagesTags ($pages) {
    $tagsObject = new StdClass();
    $tagsObject->tags = $tagsObject->pageTags = array();
    $ak = CollectionAttributeKey::getByHandle('tags');
    $db = Loader::db();

    foreach ($pages as $key => $page):
    		if ($tags = $page->getAttribute('tags')) :
    				foreach($tags->getSelectedOptions() as $value) :
                $result = $value->getSelectAttributeOptionDisplayValue();
    						$handle = preg_replace('/\s*/', '', strtolower($result));

    						$tagsObject->pageTags[$page->getCollectionID()][] =  $handle ;
                $tagsObject->pageTagsName[$page->getCollectionID()][] =  $result;
    						$tagsObject->tags[$handle] = $result;
    				endforeach;
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
  function getClassSettings ($block,$prefix) {
    $styleObject = new StdClass();
    if (is_object($block) && is_object($style = $block->getCustomStyle())) :
			$classes = $style->getStyleSet()->getCustomClass();
			$classesArray = explode(' ', $classes);
			$styleObject->classesArray = $classesArray;
      preg_match('/' . $prefix . '-(\w+)/',$classes,$found);
      return isset($found[1]) ? (int)$found[1] : false;
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

  function getPageListVariables ($b,$controller,$pages,$options = array()) {
    $options = array_merge(array(
                      'type' => 'tiny',
                      'wrapperTag' => 'div',
                      'itemTag' => 'div',
                      'AddInnerDiv' => true,
                      'topicAttributeKeyHandle' => 'project_topics',
                      'alternativeDateAttributeHandle' => 'date',
                      'hideEditMode' => true,
                      'user' => false,
                      'topics' => false,
                      'forcePopup' => false,
                      'slider' => false,
                      'additionalWrapperClasses' => array(),
                      'additionalItemClasses' => array()),
                      $options);

    /*
      Les carousels sont activé par une classe "is-carousel"
        => Ajout de la classe 'slick-wrapper' sur le wrapper
        => Ajout des options slick sous forme Ajax et en temps qu'attribut data du wrapper
      Le masonry est activé par la classe 'is-masonry' , sauf si carousel.
        => Le wrapper contient la classe "masonry-wrapper"
        => Le wrapper contient l'attribut data-gridsizer avec la classe des colonnes
        -- Si pas masonery
          => ajout d'un div.row tous les X
      Les filtre de tags sont activé par une classe "tag-sorting"
        => géré par elements/sortable.php
      Les filtre keywords sont activé par une classe "keywords-sorting"
        => géré par elements/sortable.php
      Le nombre de colonnes pas column-x
      L'absence de marge par "no-gap"
      L'affichage en popup est activé par la classe "popup-link" ou par l'option 'forcePopup'

      Chaque page liste a un wrapper qui portera le nom du fichier en temps que classe
    */

    $vars = array();
    $c = Page::getCurrentPage();
    $nh = Loader::helper('navigation');
    $vars['th'] = $th = Loader::helper('text');
    $vars['dh'] = $dh = Core::make('helper/date');
    $request = Request::getInstance();
    $type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle($options['type']);

    $styleObject = $this->getClassSettingsObject($b);
    $tagsObject = $this->getPagesTags($pages);

    $displayUser = true;
    $displaytopics = $options['topics'];
    $displayPopup = (in_array('popup-link',$styleObject->classesArray)) || ($options['forcePopup']);
    $isCarousel = in_array('is-carousel',$styleObject->classesArray);
    $isMasonry = in_array('is-masonry',$styleObject->classesArray) && !$isCarousel;
    $isStaticGrid = !$isMasonry && !$isCarousel;

    // Theme related
    $vars['o'] = $o = $this->getOptions();
    $vars['tagsObject'] = $tagsObject;
    $vars['styleObject'] = $styleObject;
    $vars['column_class'] = ($styleObject->columns > 3 ? 'col-md-' : 'col-sm-') . intval(12 / $styleObject->columns);
    $vars['$masonryWrapperAttributes'] = 'data-gridsizer=".' . $vars['column_class'] . '" data-bid="' . $b->getBlockID() . '"';
    $vars['gap'] = (in_array('no-gap',$styleObject->classesArray)) ? 'no-gap' : 'with-gap';
    // carousels
    if ($isCarousel) :
      $slick = new StdClass();
      $slick->slidesToShow = $styleObject->columns;
      $slick->slidesToScroll = $styleObject->columns;
      $slick->margin = $styleObject->margin;
      $slick->dots = (bool)$o->carousel_dots;
      $slick->arrows = (bool)$o->carousel_arrows;
      $slick->infinite = (bool)$o->carousel_infinite;
      $slick->speed = (int)$o->carousel_speed;
      $slick->centerMode = (bool)$o->carousel_centerMode;
      $slick->variableWidth = (bool)$o->carousel_variableWidth;
      $slick->adaptiveHeight = (bool)$o->carousel_adaptiveHeight;
      $slick->autoplay = (bool)$o->carousel_autoplay;
      $slick->autoplaySpeed = (int)$o->carousel_autoplaySpeed;
      $vars['slick'] = $slick;
    endif;

    /***** Block related ****/
    $templateName = $b->getBlockFilename();
    $blockTypeHandle = str_replace('_', '-', $b->getBlockTypeHandle());
    $templateCleanName = str_replace('_', '-', substr(substr( $templateName, 0, strlen( $templateName ) -4 ),10)); // Retire le '.php' et 'supermint_'
    $vars['includeEntryText'] = ($controller->includeName || $controller->includeDescription || $controller->useButtonForLink) ? true :false;

    // Wrapper classes
    $wrapperClasses[] = 'ccm-' . $blockTypeHandle; // ccm-page-list
    $wrapperClasses[] =  $blockTypeHandle . '-' . $templateCleanName; //-> page-list-portfolio
    $wrapperClasses[] = $templateCleanName; // -> portfolio
    if ($isCarousel) 	$wrapperClasses[] = 'slick-wrapper ';
    if ($isMasonry) 	$wrapperClasses[] = 'masonry-wrapper';
    $wrapperClasses[] = 'wrapper-'. $styleObject->columns . '-column';
    // $wrapperClasses[] = 'row';
    $wrapperClasses[] = (in_array('no-gap',$styleObject->classesArray)) ? 'no-gap' : 'with-gap';
    // Wrapper attributes
    $wrapperAtrtribute[] = 'data-bid="' . $b->getBlockID() . '"';
    if ($isMasonry) $wrapperAtrtribute[] = 'data-gridsizer=".' . $vars['column_class'] . '"';
    if ($isCarousel) $wrapperAtrtribute[] = 'data-slick=\'' . json_encode($slick) . '\'';
    // Finally, wrapper html
    $vars['wrapperOpenTag'] = '<' . $options['wrapperTag'] . ' class="' . implode(' ', array_merge($wrapperClasses,$options['additionalWrapperClasses'])) . '" ' . implode(' ', $wrapperAtrtribute) . '>';
    $vars['wrapperCloseTag'] = '</' . $options['wrapperTag'] . '><!-- end .' . $blockTypeHandle . '-' . $templateCleanName . ' -->';
    // Item classes
    if(!$isCarousel) $itemClasses[] = $vars['column_class'];
    $itemClasses[] = 'item';
    if ($isMasonry) $itemClasses[] = 'masonry-item';
    // itemTag
    $itemAttributes = array();
    if($isCarousel) $itemAttributes[] = (in_array('no-gap',$styleObject->classesArray) ? '' : 'style="margin:0 15px"');

    /*****  Page related -- *****/

    foreach ($pages as $key => $page):
      $page->mclDetails = array();
      $externalLink = $page->getAttribute('external_link');
      $page->mclDetails['url'] = $externalLink ? $externalLink : $nh->getLinkToCollection($page);
      $page->mclDetails['popupClassLauncher'] = '';
      $page->mclDetails['render'] = false;
      $page->mclDetails['popup'] = false;

      // Popup
      if ($page->getPageTemplateHandle() == 'one_page_details' && $displayPopup):
        $v = $page->mclDetails['v'] = $page->getController()->getViewObject();
        $page->isPopup = true;
        $page->mclDetails['url'] = "#mcl-popup-{$page->getCollectionID()}";
        $page->mclDetails['popupClassLauncher'] = 'open-popup-link';
        $request->setCurrentPage($page);
        $page->mclDetails['render'] = $v->render("one_page_details");
        $page->mclDetails['popup'] = '<div class="white-popup mfp-hide large-popup" id="mcl-popup-' . $page->getCollectionID() .'">' . $page->mclDetails['render'] . '</div>';
        $request->setCurrentPage($c);
      endif;

      // target
      $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
      $target = empty($target) ? '_self' : $target;
      $page->mclDetails['target'] = $target;
      $page->mclDetails['link'] = 'href="' . $page->mclDetails['url'] . '"' . ' target="' . $page->mclDetails['target'] . '"';
      $page->mclDetails['to'] = $page->mclDetails['link'] . ' class="' . $page->mclDetails['popupClassLauncher'] . '"';

      // title
      $title_text =  $th->entities($page->getCollectionName());
      $page->mclDetails['title'] = $controller->useButtonForLink ? $title_text : ('<a ' . $page->mclDetails['to'] . '>' . $title_text . '</a>') ;
      $page->mclDetails['name'] = $title_text;

      // date
      $eventDate = $page->getAttribute($options['alternativeDateAttributeHandle']);
      $page->mclDetails['date'] =  $eventDate ? $dh->formatDate($eventDate) : date('M / d / Y',strtotime($page->getCollectionDatePublic()));
      $page->mclDetails['rawdate'] =  $eventDate ? $dh->formatDate($eventDate) : strtotime($page->getCollectionDatePublic());

      // user
      if ($displayUser) $page->mclDetails['original_author'] = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

      // tags
      $tagsArray = $tagsObject->pageTags[$page->getCollectionID()];
      $page->mclDetails['tagsArray'] = $tagsObject->pageTagsName[$page->getCollectionID()] ? $tagsObject->pageTagsName[$page->getCollectionID()] : array();

      // topics
      if ($displaytopics) $page->mclDetails['topics'] = $page->getAttribute($options['topicAttributeKeyHandle']);

      // description
      if ($controller->includeDescription):
        $description = $page->getCollectionDescription();
        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
        $page->mclDetails['description'] = $th->entities($description);
      endif;

      // Icon
      $page->mclDetails['icon'] = $page->getAttribute('icon') ? "<i class=\"fa {$page->getAttribute('icon')}\"></i>" : false;

      // Thumbnail
      if ($controller->displayThumbnail) :
        $img_att = $page->getAttribute('thumbnail');
        if (is_object($img_att)) :
          $img = Core::make('html/image', array($img_att, true));
          $page->mclDetails['imageTag'] = $img->getTag();
          $page->mclDetails['thumbnailUrl'] = ($type != NULL) ? $img_att->getThumbnailURL($type->getBaseVersion()) : false;
          $page->mclDetails['imageUrl'] = $img_att->getURL();
        else :
          $page->mclDetails['imageTag'] = $page->mclDetails['thumbnailUrl'] = false;
        endif;
      endif;

      // Item classes
      $itemClassesTemp = $itemClasses;
      $itemClassesTemp[] = $key % 2 == 1 ? 'pair' : 'impair';
      $itemClassesTemp[] = $tagsArray ? implode(' ',$tagsArray) : '';
      // Item tag
      $page->mclDetails['itemOpenTag'] = (($key%$styleObject->columns == 0 && $isStaticGrid) ? '<div class="row' . (in_array('no-gap',$styleObject->classesArray) ? ' no-gap' : '') . '">' : '') . '<' . $options['itemTag'] . ' class="' .implode(' ',  array_merge($itemClassesTemp,$options['additionalItemClasses'])) . '" ' . implode(' ', $itemAttributes) . '>' . ($options['AddInnerDiv'] ? '<div class="inner">' : '');
      $page->mclDetails['itemCloseTag'] = ($options['AddInnerDiv'] ? '</div>' : '') . '</' . $options['itemTag'] . '>' . (($key%$styleObject->columns == ($styleObject->columns) - 1 || ($key == count($pages)-1)) && $isStaticGrid ? '</div><!-- .row -->' : '');

    endforeach;
    if ($c->isEditMode() && $options['hideEditMode']) :
        echo '<div class="ccm-edit-mode-disabled-item">';
        echo '<p style="padding: 40px 0px 40px 0px;">' .
          '[ ' . $blockTypeHandle . ' ] ' .
          '<strong>' .
          ucwords($templateCleanName) .
          ($isCarousel ? t(' carousel') : '') .
          ($isMasonry ? t(' masonry') : '') .
          ($isStaticGrid ? t(' static grid') : '') .
          '</strong>' .
          t(' with ') .
          $styleObject->columns .
          t(' columns and ') .
          (!(in_array('no-gap',$styleObject->classesArray)) ? t(' regular Gap ') : t('no Gap ')) .
          t(' disabled in edit mode.') .
          '</p>';
        echo '</div>';
    endif;

    if ($controller->pageListTitle):
      echo '<div class="page-list-header">';
      echo '<h3>' . $controller->pageListTitle . '</h3>';
      echo '</div>';
    endif;

    if (!$c->isEditMode() && $isMasonry)
      Loader::PackageElement("page_list/sortable", 'theme_supermint', array('o'=>$o,'tagsObject'=>$tagsObject,'bID'=>$b->getBlockID(),'styleObject'=>$styleObject));

    return $vars;

  }
  function nl2p($string)  {
      $paragraphs = '';
      foreach (explode("\n", $string) as $line) if (trim($line)) $paragraphs .= '<p>' . $line . '</p>';
      return $paragraphs;
  }

  function contrast ($hexcolor, $dark = '#000000', $light = '#FFFFFF') {
      return (hexdec($hexcolor) > 0xffffff/2) ? $dark : $light;
  }




}
