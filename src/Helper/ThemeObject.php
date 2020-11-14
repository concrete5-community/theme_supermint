<?php
namespace Concrete\Package\ThemeSupermint\Src\Helper;

defined('C5_EXECUTE') or die("Access Denied.");

class ThemeObject {

  static function get ($c = NULL) {
    if (is_object($c)) :
      $t = $c->getCollectionThemeObject();
      // echo $t->getThemeHandle(); die(' - mmmh');
      if (is_object($t) && $t->getThemeHandle() == 'supermint') :
        return $t;
        else :
          return \Concrete\Core\Page\Theme\Theme::getByHandle('supermint');
      endif;
    endif;
  }
}
