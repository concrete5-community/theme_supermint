<?php
namespace Concrete\Package\ThemeSupermint\Attribute\Color;

defined('C5_EXECUTE') or die(_("Access Denied."));

use Loader;
use View;
use \Concrete\Core\Attribute\DefaultController;

class Controller extends DefaultController  {

    protected $searchIndexFieldDefinition = array(
        'type' => 'string',
        'options' => array('default' => null, 'notnull' => false)
    );

   public function getDisplayValue() {

      if (is_object($this->attributeValue)) {
         $value = $this->getAttributeValue()->getValue();
      } else {
         $value= '#ffffff';
      }

      $contrast = $this->get_contrast_color(substr($value,1,6));
      return "<span style='background:$value; padding:4px; color:#$contrast'>$value</span>";

   }


   public function form() {
      if (is_object($this->attributeValue)) {
         $value = $this->getAttributeValue()->getValue();
      }
      $fieldFormName = 'akID['.$this->attributeKey->getAttributeKeyID().'][value]';
      $inputName = 'akID'.$this->attributeKey->getAttributeKeyID();

      $view = View::getInstance();
      $view->requireAsset('core/colorpicker');

        print "<input type=\"text\" name=\"{$fieldFormName}\" value=\"{$value}\" id=\"ccm-colorpicker-{$inputName}\" />";
        print "<script type=\"text/javascript\">";
        print "$(function() { $('#ccm-colorpicker-{$inputName}').spectrum({
            showInput: true,
            showInitial: true,
            preferredFormat: 'rgb',
            allowEmpty: true,
            className: 'ccm-widget-colorpicker',
            showAlpha: true,
            // value: " . json_encode($value) . ",
            cancelText: " . json_encode(t('Cancel')) . ",
            chooseText: " . json_encode(t('Choose')) . ",
            clearText: " . json_encode(t('Clear Color Selection')) . "
        });});";
        print "</script>";

   }

  function get_contrast_color($hex, $c = 120 ) {

      $rgb = array(substr($hex,0,2), substr($hex,2,2), substr($hex,4,2));

      if(hexdec($rgb[0]) + hexdec($rgb[1]) + hexdec($rgb[2]) > 382){

      }else{
         $c = -$c;
      }

      for($i=0; $i < 3; $i++) :

    if((hexdec( $rgb[$i]) - $c ) >= 0 )  :

      $rgb[$i] = hexdec($rgb[$i]) - $c;
      $rgb[$i] = dechex($rgb[$i]);

      if(hexdec($rgb[$i]) <= 9) :
        $rgb[$i] = "0".$rgb[$i];
      elseif (hexdec($rgb[$i]) == 10 ) :
        $rgb[$i] = $rgb[$i] . $rgb[$i];
      endif;

    else :
        $rgb[$i] = "00";
    endif;

      endfor;

      return $rgb[0].$rgb[1].$rgb[2];
  }


}
