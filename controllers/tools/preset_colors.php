<?php
namespace Concrete\Package\ThemeSupermint\Controller\Tools;

use \Concrete\Core\Controller\Controller as RouteController;
use Loader;
use Less_Parser;
use Less_Cache;
use Less_Tree_Rule;
use PageTheme;
use Page;
use Config;
use StdClass;

// TODO Simplifier la recherche de contraste, sans passer par une couleur HEX et avec la maitrise du point de bascule */

defined('C5_EXECUTE') or die(_("Access Denied."));

class PresetColors extends RouteController {


    function getColors () {
        $session = \Core::make('session');
        $colorsObject = $session->get('supermint.colors');
        echo json_encode($colorsObject);
    }

	function GetColorsFromPage () {
        $c = $_REQUEST['cID'] ? Page::getByID($_REQUEST['cID']) : Page::getCurrentPage();
        if (!$c) die(t('Can\'t retrieve a Page to get Preset color'));
        $cID = $c->getCollectionID();
        $pt = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
        $packageHandle = $pt->getPackageHandle();
        $themeHandle = $pt->getThemeHandle();
        $presets = $pt->getThemeCustomizableStylePresets();
        // Si on a un tableau vide, onest surement sur une single page ou dans le dashboard, on sort
        if (is_array($presets) && count($presets) === 0 ) return false;
        // On recupère le preset par defaut
        foreach ($presets as $preset) { if ($preset->isDefaultPreset()) $defaultPreset = $preset; }

        $colorsObject = new stdClass();

        // Si cette page a un style specifique
        if ($c->hasPageThemeCustomizations())
            $customStyleObject = $c->getCustomStyleObject();
        // Sinon, on prend le style du thème, global a plusieurs pages
        else
            $customStyleObject = $pt->getThemeCustomStyleObject();

        // Si on a pu recupérer le style
        if (is_object($customStyleObject)) {
            // On teste si il a style dependant d'un preset
            $handle = $customStyleObject->getPresetHandle();
            if ($handle) {
                // dans ce cas on prend le preset actif
                $selectedPreset = $pt->getThemeCustomizablePreset($handle);
            }
            // on recupère la liste de valeur du preset actif
            $valueList = $customStyleObject->getValueList();
        // Sinon, on prend le preset par default
        } else {
            $selectedPreset = $defaultPreset;
            $valueList = $defaultPreset->getStyleValueList();
        }


        // Retrieve all variables in a Array
        foreach ($valueList->getValues() as $key => $value) :
            $valueArray = $value->toLessVariablesArray();
            $k = array_keys($valueArray);
            $k = $k[0];
            $v = array_values($valueArray);
            $variables[$k] = $v[0];
        endforeach;

        $colorsObject->variables = $variables;

        // Build color array
        foreach (self::getColorsVariablesName() as $color) :
            $colorsObject->colors[$color] = $variables[$color . '-color'];
        endforeach;

        // Build Contrast array
        foreach (self::getContrastVariablesName() as $contrast) :
            $colorsObject->contrast[$contrast . '-contrast'] = self::contrast(
                self::rgb2hex($variables[$contrast . '-color']),
                self::rgb2hex($variables['black-color']),
                self::rgb2hex($variables['white-color'])
                );
        endforeach;
    	return $colorsObject;
	}

    function getColorsVariablesName () {
        return array('primary','secondary','tertiary','quaternary','white','black','success','info','warning','danger','light','grey');
    }
    function getContrastVariablesName () {
        return array('primary','secondary','tertiary','quaternary');
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

    function contrast ($hexcolor, $dark = '#000000', $light = '#FFFFFF') {
        return (hexdec($hexcolor) > 0xffffff/2) ? $dark : $light;
    }
}
