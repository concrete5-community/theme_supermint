<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

$options = array(
    array(
        'name' => t("Page-list Carousel"),
        'desc' => t("Supermint offer multiple custom template for the built-in page-list block that display pages into a carousel. Below you will fint options to take the controls of different settings"),
        "icon" => 'fa-ellipsis-h',
        'type' => 'section'
    ),
    array(
        "name" => t("Default number of Pages to show"),
        'desc' => t('How many items per view by default. This can be override by custom classes on the block itself (eg: column-4)'),
        "id" => "carousel_slidesToShow",
        "min" => "1",
        "max" => "12",
        "step" => "1",
        "unit" => 'blocks',
        "default" => "3",
        "type" => "range"
    ),
    array(
        "name" => t("Default Margins"),
        'desc' => t('Default Margins between items. This can be override by custom classes on the block itself (eg: carousel-margin-10)'),
        "id" => "carousel_margin",
        "min" => "0",
        "max" => "50",
        "step" => "1",
        "unit" => 'px',
        "default" => "10",
        "type" => "range"
    ),
    array(
        "name" => t("Display Dots"),
        "desc" => t("Display small dots under the pages"),
        "id" => 'carousel_dots',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Display Arrows"),
        "desc" => t("Display Arrow on top right of pages"),
        "id" => 'carousel_arrows',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Infinite"),
        "desc" => t('Infinite loop sliding'),
        "id" => 'carousel_infinite',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Center Mode"),
        'desc' => t('Enables centered view with partial prev/next slides.'),
        "id" => 'carousel_centerMode',
        "default" => false,
        "type" => "toggle"
    ),
    array(
        "name" => t("Adaptive Height"),
        "desc" => t('Enables adaptive height for single slide horizontal carousels.'),
        "id" => 'carousel_adaptiveHeight',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Auto Play"),
        "id" => 'carousel_autoplay',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Scroll Speed"),
        "id" => "carousel_speed",
        "min" => "100",
        "max" => "2000",
        "step" => "10",
        "unit" => 'ms',
        "default" => "300",
        "type" => "range"
    ),
    array(
        "name" => t("Auto Play Speed"),
        "id" => "carousel_autoplaySpeed",
        "min" => "1000",
        "max" => "8000",
        "step" => "500",
        "unit" => 'ms',
        "default" => "5000",
        "type" => "range"
    ),
    array(
        "name" => t("Display meta"),
        "desc" => t('Display Meta information like user. You need also to activate the Date display option in the block edit.'),
        "id" => 'carousel_meta',
        "default" => true,
        "type" => "toggle"
    ),



        //  Stack Carousel


        array(
            'name' => t("Stack Carousel"),
            'desc' => t("Supermint offer a custom template for Satck displayer that display blocks into a carousel or slider. Below you will fint options to take the controls of different settings of this Carousel"),
            "icon" => 'fa-ellipsis-h',
            'type' => 'section'
        ),
        array(
            "name" => t("Default blocks to show"),
            'desc' => t('How many block per view by default.  This can be override by custom classes on the block itself (eg: margin-10)  '),
            "id" => "stack_carousel_slidesToShow",
            "min" => "1",
            "max" => "6",
            "step" => "1",
            "unit" => 'block',
            "default" => "3",
            "type" => "range"
        ),
        array(
            "name" => t("Margins"),
            'desc' => t('Margins between items'),
            "id" => "stack_carousel_margin",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "default" => "10",
            "type" => "range"
        ),
        array(
            "name" => t("Display Dots"),
            "id" => 'stack_carousel_dots',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("Display Arrows"),
            "desc" => t("Display Arrow on top right of blocks"),
            "id" => 'stack_carousel_arrows',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("Infinite"),
            "desc" => t('Infinite loop sliding'),
            "id" => 'stack_carousel_infinite',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("Center Mode"),
            'desc' => t('Enables centered view with partial prev/next slides.'),
            "id" => 'stack_carousel_centerMode',
            "default" => false,
            "type" => "toggle"
        ),
        array(
            "name" => t("Adaptive Height"),
            "desc" => t('Enables adaptive height for single slide horizontal carousels.'),
            "id" => 'stack_carousel_adaptiveHeight',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("Auto Play"),
            "id" => 'stack_carousel_autoplay',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("Scroll Speed"),
            "id" => "stack_carousel_speed",
            "min" => "100",
            "max" => "2000",
            "step" => "10",
            "unit" => 'ms',
            "default" => "300",
            "type" => "range"
        ),
        array(
            "name" => t("Auto Play Speed"),
            "id" => "stack_carousel_autoplaySpeed",
            "min" => "1000",
            "max" => "8000",
            "step" => "500",
            "unit" => 'ms',
            "default" => "5000",
            "type" => "range"
        ),



    // Supermint Simple image slide


    array(
        'name' => t("Simple slide"),
        'desc' => t('The custom template "Supermint simple" on the built-in "image-slider" block use great CSS3 animation for image transitions. You can pick here the one you love.'),
        "icon" => 'fa-picture-o',
        'type' => 'section'
    ),
    array(
        "name" => t("Image Slider Transition"),
        "id" => "image_slider_effect",
        "default" => 'fxSoftScale',
        "options" => array(
            "fxSoftScale" => t('Soft scale'),
            "fxPressAway" => t('Press away'),
            "fxSideSwing" => t('Side Swing'),
            "fxFortuneWheel" => t('Fortune wheel'),
            "fxSwipe" => t('Swipe'),
            "fxPushReveal" => t('Push reveal'),
            "fxSnapIn" => t('Snap in'),
            "fxLetMeIn" => t('Let me in'),
            "fxStickIt" => t('Stick it'),
            "fxArchiveMe" => t('Archive me'),
            "fxVGrowth" => t('Vertical growth'),
            "fxSlideBehind" => t('Slide Behind'),
            "fxSoftPulse" => t('Soft Pulse'),
            "fxEarthquake" => t('Earthquake'),
            "fxCliffDiving" => t('Cliff diving')
        ),
        "type" => "select"
    ),


    //  Image slide - slider Custom template


    array(
        'name' => t("Image Slider"),
        'desc' => t("Options when 'Supermint Slider' is choosed as custom template for the Image Slider block"),
        "icon" => 'fa-picture-o',
        'type' => 'section'
    ),
    array(
        "name" => t("Image to show"),
        'desc' => t('How many items per view'),
        "id" => "image_slider_slidesToShow",
        "min" => "1",
        "max" => "6",
        "step" => "1",
        "unit" => 'image',
        "default" => "1",
        "type" => "range"
    ),
    array(
        "name" => t("Margins"),
        'desc' => t('Margins between images'),
        "id" => "image_slider_margin",
        "min" => "0",
        "max" => "50",
        "step" => "1",
        "unit" => 'px',
        "default" => "10",
        "type" => "range"
    ),
    array(
        "name" => t("Display Dots"),
        "desc" => t("Display small dots under the pages"),
        "id" => 'image_slider_dots',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Display Arrows"),
        "desc" => t("Display Arrows on top right of blocks"),
        "id" => 'image_slider_arrows',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Infinite"),
        "desc" => t('Infinite loop sliding'),
        "id" => 'image_slider_infinite',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Adaptive Height"),
        "desc" => t('Enables adaptive height for single slide horizontal carousels.'),
        "id" => 'image_slider_adaptiveHeight',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Auto Play"),
        "id" => 'image_slider_autoplay',
        "default" => true,
        "type" => "toggle"
    ),
    array(
        "name" => t("Auto Play Speed"),
        "id" => "image_slider_autoplaySpeed",
        "min" => "1000",
        "max" => "8000",
        "step" => "500",
        "unit" => 'ms',
        "default" => "5000",
        "type" => "range"
    ),
    array(
        "name" => t("Scroll Speed"),
        "id" => "image_slider_speed",
        "min" => "100",
        "max" => "2000",
        "step" => "10",
        "unit" => 'ms',
        "default" => "300",
        "type" => "range"
    ),




    // -- Submit -- \\

    array(
        'type' => 'submit',
        'name' => t("Save"),
        'id' => 'saved'
    )
);
if (!isset($passThrough))
new Concrete\Package\ThemeSupermint\Src\Helper\OptionsGenerator($options, $pID, $this->action('save_options'), $this->action('view'));
