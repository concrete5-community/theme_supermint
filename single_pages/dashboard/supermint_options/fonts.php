<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

$options = array(
    array(
        'name' => t("Fonts from Google"),
        "desc" => t('In this section choose which font to which element. Also choose one or more variations, so that the italic and bold styles have their police.'),
        "icon" => 'fa-font',
        'type' => 'section'
    ),    
    array(
        "name" => t("Global page Font"),
        "desc" => t("This font is used on all elements except those below"),
        "id" => "p",
        "default" => 'Roboto',
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for alternate text"),
        "desc" => t("Choose a font for the alternate class (available in the WYSIWYG editor)"),
        "id" => "alternate",
        "default" => 'Pacifico',
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-1"),
        "desc" => t("H1"),
        "id" => "h1",
        "default" => "Roboto Condensed",
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-2"),
        "desc" => t("H2"),
        "id" => "h2",
        "default" => "Roboto Condensed",
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-3"),
        "desc" => t("H3"),
        "id" => "h3",
        "default" => "Roboto Condensed",
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-4 "),
        "desc" => t("H4"),
        "id" => "h4",
        "default" => "Roboto",
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles leve 5 "),
        "desc" => t("H5"),
        "id" => "h5",
        "default" => "Roboto",
        "type" => "custom",
        "function" => "font"
    ),
    array(
        "name" => t("Fonts for Titles leve 6 "),
        "desc" => t("H6"),
        "id" => "h6",
        "default" => "Roboto",
        "type" => "custom",
        "function" => "font"
    ),    
    array(
        "name" => t("Fonts for small tags into heading"),
        "desc" => t("You can add rythm to your heading by adding a \<small\> tag into it"),
        "id" => "small",
        "default" => "Roboto Condensed",        
        "type" => "custom",
        "function" => "font"
    ),
    
    /* --- Measurements --- */
    
    array(
        'name' => t("Fonts size"),
        'desc' => t("Choose font-size in pixels for elements"),
        'icon' => 'fa-text-height',
        'type' => 'section'
    ),
    array(
        'name' => t("Paragraph size is defined in the Theme Customization Panel"),
        'desc' => t("This option is only defined in the theme customization"),
        'type' => 'subsection'
    ),
    array(
        "name" => t("H1"),
        "id" => "h1_size",
        "default" => 50,
        "min" => 12,
        "max" => 60,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("H2"),
        "id" => "h2_size",
        "default" => 35,
        "min" => 10,
        "max" => 45,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("H3"),
        "id" => "h3_size",
        "default" => 25,
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("H4"),
        "id" => "h4_size",
        "default" => 20,
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("H5"),
        "id" => "h5_size",
        "default" => 17,
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("H6"),
        "id" => "h6_size",
        "default" => 16,
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),    
    array(
        "name" => t("'Lead' class"),
        "id" => "lead_size",
        "default" => 14,
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("'Alternate' class"),
        "id" => "alternate_size",
        "default" => .8,
        "min" => .1,
        "max" => 3,
        "step" => .1,
        "unit" => 'em',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size (in em) for small tag in titles"),
        "id" => "small_tag_size",
        "default" => .8,
        "min" => .1,
        "max" => 2,
        "step" => .1,
        "unit" => 'em',
        "type" => "range"
    ),
    array(
        "name" => t("Font variation"),
        "icon" => 'fa-underline',
        "type" => "section"
    ),
    array(
        "name" => t("Make H1 uppercase"),
        "id" => "h1_upp",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Make H2 uppercase"),
        "id" => "h2_upp",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Make H3 uppercase"),
        "id" => "h3_upp",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Make H4 uppercase"),
        "id" => "h4_upp",
        "default" => 1,
        "type" => "toggle"
    ),
    array(
        "name" => t("Make H5 uppercase"),
        "id" => "h5_upp",
        "default" => 0,
        "type" => "toggle"
    ),
    array(
        "name" => t("Make H6 uppercase"),
        "id" => "h6_upp",
        "default" => 0,
        "type" => "toggle"
    ),
    
    array(
        "name" => t("Responsive text"),
        'icon' => 'fa-mobile',
        "desc" => t("Size above are used on regular display (between 980px & 1200px). To keep proportionalities, fonts are tailored to bigger & smaller screens with a ratio. You can adjust the ratio if the result does not satisfy you on your tablet or phone."),
        "type" => "section"
    ),
    array(
        "name" => t("Ratio for bigger desktop screen (more that 1200px)"),
        "desc" => t("I think the most popular screen size"),
        "id" => "wide_ratio",
        "default" => 1.24,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),
    array(
        "name" => t("Ratio for Portrait tablets "),
        "id" => "w724_ratio",
        "default" => 1.30,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),
    array(
        "name" => t("Ratio for Phones & tablets "),
        "id" => "full_ratio",
        "default" => 1.30,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),
    array(
        "name" => t("Text minimun limit."),
        "desc" => t("This option prevent to have too small text on tablet or mobiles."),
        "id" => "size_minimum",
        "default" => 12,
        "min" => 5,
        "max" => 20,
        "step" => 1,
        "unit" => '',
        "type" => "range"
    ),
    array(
        'type' => 'submit',
        'name' => t("Save")
    )
);



if (!isset($passThrough)) :
new Concrete\Package\ThemeSupermint\Src\Helper\OptionsGenerator($options, $pID, $this->action('save_options'), $this->action('view'));
?>
<script>
    var FONT_DETAILS_TOOLS_URL = "<?php echo URL::to('/ThemeSupermint/tools/font_details')?>";
</script>
<?php endif ?>