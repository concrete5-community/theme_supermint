<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

$options = array(
    array(
        "name" => t("Layout"),
        "icon" => 'fa-file',
        "type" => "section",
        "desc" => t('For each page of the site play with these options to fine tunne design details as optionnal Area, Boxed layout, Side-bar size..')
    ),
    array(
        "name" => t("Enable responsive layout"),
        "desc" => t("If enabled, all layouts will be adapted for small screen. If disabled the site will be rendered as desktop on mobile & tablets"),
        "id" => "responsive",
        "default" => 1,
        "type" => "toggle"
    ),
    array(
        "name" => t("Display wide Top Area"),
        "desc" => t("Display a Area under the logo to add some widther content"),
        "id" => "display_top_area",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Display Top Bar"),
        "desc" => t("Display zone with Logo Area, right Header content,.. Disable this for the Wide navigation style"),
        "id" => "display_top_bar_area",
        "default" => 0,
        "type" => "toggle"
    ),    
    array(
        "name" => t("Layout mode"),
        "desc" => t("Each page templates can be displayed in a wide or a Boxed format. Boxed format use the color 'boxed-background-color' as background"),
        "id" => "layout_mode",
        "default" => "wide-wrapper",
        "options" => array(
            'boxed-wrapper' => t("Boxed"),
            'wide-wrapper' => t("Wide")
        ),
        "default" => "wide-wrapper",
        "type" => "select"
    ),
    array(
        "name" => t("Sidebar width size"),
        "desc" => t('Add or remove a column in the sidebar'),
        "id" => "sidebar_size",
        "default" => 4,
        "options" => array(
            5 => t("Large"),
            4 => t("Normal"),
            3 => t("thin")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Sidebar padding"),
        "desc" => t('Add space between the sidebar border and the content'),
        "id" => "sidebar_padding",
        "default" => 'space-s',
        "options" => array(
            'space-m' => t("Large"),
            'space-s' => t("Normal"),
            'space-xs' => t("thin"),
            'zero' => t("None")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Add Space between sidebar and the Main content area"),
        "desc" => t(''),
        "id" => "sidebar_offset",
        "default" => 0,
        "options" => array(
            2 => t("Large"),
            1 => t("thin"),
            0 => t("None")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Content padding"),
        "desc" => t('Add or remove space between border and content in the Main content area'),
        "id" => "content_padding",
        "default" => 'space-s',
        "options" => array(
            'space-m' => t("Large"),
            'space-s' => t("Normal"),
            'space-xs' => t("Thin"),
            'zero' => t("None")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Blocks templates"),
        "desc" => t('In this section you find options to controls Block\'s custom template details'),
        "icon" => 'fa-th-large',
        "type" => "section"
    ),
    array(
        'name' => t('Autonav'),
        "desc" => t('Options for the Built-in "Autonav" block'),
        'type' => 'subsection'
    ),     
    array(
        "name" => t("Display button"),
        "desc" => t('Display a link button on certain Feature block template'),
        "id" => "autonav_horizontal_icon",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        'name' => t('Feature'),
        "desc" => t('Options for the Built-in "Feature" block'),
        'type' => 'subsection'
    ),
    array(
        "name" => t("Display button"),
        "desc" => t('Display a link button on certain Feature block template'),
        "id" => "feature_link_button",
        "default" => 1,
        "type" => "toggle"
    ),
    array(
        "name" => t("Button text"),
        "desc" => t('The default text to add on the button'),
        "id" => "feature_link_text",
        "size" => 40,
        "type" => "text",
        "default" => t('More')
    ),
    array(
        'name' => t('Autonav'),
        "desc" => t('Options for the Built-in "Autonav" block'),
        'type' => 'subsection'
    ),
    array(
        "name" => t("Icon class on left of each navigation title"),
        "desc" => t("Pick a icon from the <a href='http://fontawesome.io/icons/'>FontAwesome</a> Librairy. this icon will be used throught all autonav template"),
        "id" => "default_nav_block_icon",
        "type" => "awesome",
        "default" => 'fa-chevron-circle-right'
    ),
    array(
        "name" => t("Supermint Navigation"),
        "desc" => t('This section display options common for the navigation\'s types'),
        "icon" => 'fa-list',
        "type" => "section"
    ),
    array(
        "name" => t("Navigation Style"),
        "desc" => t("Choose the navigation style"),
        "id" => "navigation_style",
        "default" => 'dropdown',
        "options" => array(
            'slide' => t("Slide mode"),
            'regular-top-nav' => t("Regular drop-down mode"),
            'main-large-nav' => t('Wide drop-down mode'),
            'lateral-regular' => t('Lateral mode')
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Disable Auto embed navigation"),
        "desc" => t("If disabled, a global area will let you put whitch block you want for nav"),
        "id" => "disable_embed_nav",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Choose a page for searching result"),
        "desc" => t("Display Search box in the top of the page if a page is selected. Add a block search on this page to display result."),
        "id" => "display_searchbox",
        "default" => '0',
        "quick" => false,
        "activated" => true,
        "type" => "page"
    ),
    array(
        "name" => t("Display icon on first level if available"),
        "desc" => t("If the atrtribute 'icon' is filled on a first-level page it will be displayed in the top-nav"),
        "id" => "first_level_nav_icon",
        "default" => 1,
        "type" => "toggle"
    ),
    array(
        'name' => t('Dropdown mode'),
        "desc" => t('Options When the nav is in dropdown mode'),
        'type' => 'subsection'
    ),         
     array(
        "name" => t("Dropdown Width"),
        "desc" => t("Set width for dropdown in main navigation when it's on dropdown mode"),
        "id" => "nav_sub_level_width",
        "min" => "150",
        "max" => "400",
        "step" => "10",
        "unit" => 'px',
        "default" => "220",
        "type" => "range"
    ),
    array(
        'name' => t('Dropdown multicolumns mode'),
        "desc" => t('Options When the nav is in dropdown mode and the attribute "Display multi-columns dropdown" is activated'),
        'type' => 'subsection'
    ),      
    array(
        "name" => t("Multicolumns position"),
        "desc" => t("Display multi-columns nav as full with or under parent"),
        "id" => "full_width_multicolumn",
        "default" => 0,
        "options" => array(
            0 => t("Aligned on left of the parent"),
            1 => t("Full width mega-menu")
        ),
        "type" => "select"
    ),
     array(
        "name" => t("Number of link per columns"),
        "desc" => t("Tthis setting allow you to set the number of items by columns (only if the \"breack by parent\" (below)) is desactivated "),
        "id" => "nav_multicolumns_item_per_column",
        "min" => "1",
        "max" => "40",
        "step" => "1",
        "unit" => 'link',
        "default" => "5",
        "type" => "range"
    ),
    array(
        "name" => t("Activate the breack by parent"),
        "desc" => t("The number of columns is detreminated by the number of child page in second level"),
        "id" => "break_columns_on_child",
        "default" => 1,
        "type" => "toggle"
    ),
    array(
        'name' => t('Lateral mode'),
        "desc" => t('Options When the nav is diplayed on left'),
        'type' => 'subsection'
    ),         
    array(
        "name" => t("Use 'Alternate' Font style for navigation"),
        "desc" => t("If enabled this options take the alternate Font settings for navigation Items"),
        "id" => "use_alternate_on_lateral_nav",
        "default" => 0,
        "type" => "toggle"
    ),    
    // array(
    //     "name" => t("Header position"),
    //     "desc" => t("Choose to display the header from stack (named 'Lateral Navigation Header') in top or bottom"),
    //     "id" => "header_position_on_lateral_nav",
    //     "default" => 'top',
    //     "options" => array(
    //         'top' => t("Aligned on Top"),
    //         'middle' => t("Aligned on Middle"),
    //         'bottom' => t("Aligned on Bottom")
    //     ),
    //     "type" => "select"
    // ),
   array(
        "name" => t("Mega menu options"),
        "desc" => t('Options when a parent page display a Stack as mega-menu'),
        "icon" => 'fa-th-list',
        "type" => "section"
    ),
    array(
        "name" => t("Mega menu position when dropdown mode"),
        "desc" => t("Display a mega menu as full with or under parent"),
        "id" => "full_width_mega",
        "default" => 1,
        "options" => array(
            0 => t("Aligned on left of the parent with fixed columns width"),
            1 => t("Full width mega-menu with percent based columns width")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Mega columns width"),
        "desc" => t("Columns width in pixels for mega menu when aligned to the left"),
        "id" => "mega_columns_width",
        "min" => "100",
        "max" => "600",
        "step" => "10",
        "unit" => 'px',
        "default" => "200",
        "type" => "range"
    ),
    array(
        "name" => t("Block title when exist"),
        "desc" => t("Display the block name as title"),
        "id" => "display_title_mega_menu",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Slide Navigation options"),
        "desc" => t('Options available when navigation is set on "slide" mode'),
        "icon" => 'fa-arrows-h',
        "type" => "section"
    ),
    array(
        "name" => t("Navigation Event"),
        "desc" => t("Choose the event that activate the sliding menu (not on dropdown)"),
        "id" => "nav_event",
        "default" => t("click"),
        "options" => array(
            "click" => t("Click"),
            "mouseenter" => t("On hover")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Navigation Double click management"),
        "desc" => t("Choose to open/close or go to the url on second click"),
        "id" => "nav_dbl_click_event",
        "default" => t("url"),
        "options" => array(
            "url" => t("Go to the Url"),
            "toggle" => t("Toggle open/close")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Open on load"),
        "desc" => t("If enabled, Subnavs will be open if they are one subpage active. If desibled subnavs are closed on page load"),
        "id" => "nav_open_on_load",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Display little arrow on right"),
        "desc" => t(''),
        "id" => "nav_slide_arrow",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Sub-page icon"),
        "desc" => t("The icon from <a href='http://fontawesome.io/icons/'>FontAwesome</a> displayed on left of each sub-page"),
        "id" => "default_nav_icon",
        "type" => "awesome",
        "default" => 'fa-chevron-circle-right'
    ),
    array(
        "name" => t("Display pane title"),
        "desc" => t("Display the first level page title & link on the top of each subnav panes"),
        "id" => "display_pane_title",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Navigation column"),
        "desc" => t("How many column you want in the sub navs"),
        "id" => "nav_columns",
        "default" => 4,
        "options" => array(
            1 => t("One"),
            2 => t("Two"),
            3 => t("Three"),
            4 => t("Four"),
            6 => t("Six")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Columns margin"),
        "desc" => t("Set space between columns in percent"),
        "id" => "nav_columns_margin",
        "min" => "0",
        "max" => "15",
        "step" => "1",
        "unit" => '%',
        "default" => "2",
        "type" => "range"
    ),
    array(
        "name" => t("Open speed"),
        "desc" => t("Set the speed to open the nav"),
        "id" => "nav_open_speed",
        "min" => "0",
        "max" => "1000",
        "step" => "10",
        "unit" => 'ms',
        "default" => "300",
        "type" => "range"
    ),
    array(
        "name" => t("Close speed"),
        "desc" => t("Set the speed to close the nav"),
        "id" => "nav_close_speed",
        "min" => "0",
        "max" => "1000",
        "step" => "10",
        "unit" => 'ms',
        "default" => "300",
        "type" => "range"
    ),
    array(
        "name" => t("Slide speed"),
        "desc" => t("Set the speed when subnavs slide"),
        "id" => "nav_slide_speed",
        "min" => "0",
        "max" => "1000",
        "step" => "10",
        "unit" => 'ms',
        "default" => "300",
        "type" => "range"
    ),
    array(
        "name" => t("On mouse leave delay"),
        "desc" => t("Set the how many time wait, after the mouse leave the nav for close the nav"),
        "id" => "nav_mouseleave_delay",
        "min" => "0",
        "max" => "10000",
        "step" => "100",
        "unit" => 'ms',
        "default" => "1000",
        "type" => "range"
    ),
    array(
        "name" => t("Shorten description on subnavs"),
        "desc" => t("If set to 0 all description text will be displayed"),
        "id" => "nav_shorten_desc",
        "min" => "0",
        "max" => "800",
        "step" => "5",
        "unit" => 'Char',
        "default" => "0",
        "type" => "range"
    ),
    
    array(
        'name' => t('Footer'),
        "desc" => t('Options for the Footer section'),
        'icon' => 'fa-toggle-down',
        'type' => 'section'
    ),
    array(
        "name" => t("Display Footer"),
        "id" => "display_footer",
        "default" => 1,
        "activated" => false,
        "type" => "toggle"
    ),    
    array(
        "name" => t("Footer column"),
        "desc" => t("How many column you want in the footer"),
        "id" => "display_footer_column",
        "default" => "half_three",
        "options" => array(
            1 => t("One"),
            2 => t("Two"),
            3 => t("Three"),
            4 => t("Four"),
            "half_two" => t("One Half and two"),
            "half_three" => t("One Half and three")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Make Footer Global"),
        "desc" => t("If enabled, Block on footer will be Globals"),
        "id" => "footer_global",
        "default" => 1,
        "activated" => false,
        "type" => "toggle"
    ),
    array(
        "name" => t("RAW HTML Credits"),
        "desc" => t("If you want to change it, feel free"),
        "id" => "footer_credit",
        "cols" => 40,
        "type" => "textarea",
        "default" => '<span><i class="fa fa-magic"></i> Designed by <a href="http://www.myconcretelab.com/" rel="Concrete5 theme & addons" title="Concrete5 themes & addons by MyConcreteLab">MyConcreteLab</a></span><span class="powered-by"><i class="fa fa-cogs"></i> Powered by <a href="http://www.concrete5.org" title="concrete5 - open source content management system for PHP and MySQL">concrete5</a></span>'
    ),
    array(
        'name' => t('Popup'),
        "desc" => t(''),
        'icon' => 'fa-plus-square-o',
        'type' => 'section'
    ),
    array(
        'name' => t('CSS transitions for popup'),
        "desc" => t('Here you can set transitions for popups'),
        'type' => 'subsection'
    ),    
    array(
        "name" => t("content at start"),
        "desc" => t("CSS only"),
        "id" => "popup_content_start_css",
        "type" => "textarea",
        "default" => "opacity: 0;\n transform: translateY(-20px) perspective( 2000px ) rotateX( 10deg );"
    ),
    array(
        "name" => t("content animate it"),
        "desc" => t("CSS only"),
        "id" => "popup_content_animate_css",
        "type" => "textarea",
        "default" => 'opacity: 1; transform: translateY(0) perspective( 600px ) rotateX( 0 );'
    ),
    array(
        "name" => t("content animate out"),
        "desc" => t("CSS only"),
        "id" => "popup_content_out_css",
        "type" => "textarea",
        "default" => 'opacity: 0; transform: translateY(-20px) perspective( 2000px ) rotateX( 10deg );'
    ),
    array(
        'name' => t('Button type for popup'),
        "desc" => t('Here you can set type of button for popup'),
        'type' => 'subsection'
    ),     
    array(
        "name" => t("Button type for popup'"),
        "desc" => t("Choose between three style of button"),
        "id" => "popup_button_type",
        "default" => "button-push",
        "options" => array(
            'button-push' => t("Push"),
            'button-flat' => t("Flat"),
            'button-plain' => t("Plain")
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Button color for popup'"),
        "desc" => t("Choose between four colors"),
        "id" => "popup_button_color",
        "default" => "button-primary",
        "options" => array(
            '' => t("Default"),
            'button-primary' => t("Primary"),
            'button-success' => t("Succes"),
            'button-info' => t("Info"),
            'button-warning' => t("Warning"),
            'button-danger' => t("Danger")
        ),
        "type" => "select"
    ),
    array(
        'name' => t('Miscalenous'),
        "desc" => t(''),
        'icon' => 'fa-question-circle',
        'type' => 'section'
    ),
    array(
        "name" => t("Activate iFrame z-index script"),
        "desc" => t("This script fix a iFrame z-index isue on certain condition."),
        "id" => "fix_iframe_zindex",
        "default" => 1,
        "activated" => true,
        "type" => "toggle"
    ),
    array(
        'type' => 'submit',
        'name' => t("Save")
    )
);
if (!isset($passThrough))
new Concrete\Package\ThemeSupermint\Src\Helper\OptionsGenerator($options, $pID, $this->action('save_options'), $this->action('view'));
