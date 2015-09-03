<?php
namespace Concrete\Package\ThemeSupermint\Theme\Supermint;
use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;

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
        // $this->requireAsset('css', 'hint');
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
            'autonav' => array('small-text-size'),
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
            'image_slider' =>array_merge(array('into-columns','header-style-1','header-style-2'),$columnsClasses, $marginClasses),
            'page_attribute_display' => array('leaded','lighted'),
            'page_list' => array_merge($columnsClasses,$marginClasses),
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

}
