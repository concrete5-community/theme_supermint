<?php 
namespace Concrete\Package\ThemeSupermint\Src\Helper;

use \Concrete\Core\Page\PageList;
use \Concrete\Core\Area\Area;

defined('C5_EXECUTE') or die("Access Denied.");

class Upgrade {

  function upgrade ($pkg,$version) {
    if ($version < '3.3') :
			$this->upgradePageListTemplates();
		endif;
  }

  function upgradePageListTemplates () {
    $list = new PageList();
    $pages = $list->getResults();
    foreach ($pages as $key => $c) {
      $areas = Area::getListOnPage($c);
      foreach ($areas as $area) {
        $blocks = $area->getAreaBlocksArray();
        foreach ($blocks as $block) {
          if ($block->getBlockTypeHandle() == 'page_list') {
            $templateName = $block->getBlockFilename();
            preg_match("/supermint_(\w+)_(\w+)\.php/",$templateName,$matches);
            if (count($matches)) {
              if ($matches[1] == 'carousel') $this->setBlockClass($block,'is-carousel',$matches[2]);
              if ($matches[1] == 'static' && $matches[2] == 'block') $this->setBlockClass($block,'',$matches[2]);
              if ($templateName == 'supermint_recent_post.php') $this->setBlockClass($block,'1-column',false);
              if ($matches[1] == 'icon') $this->setBlockClass($block,'is-masonry',false);
            }
          }
        }
      }
    }
  }
  function setBlockClass ($block,$class,$name) {
    $style = $block->getCustomStyle(true);
    if (is_object($style)) {
      $ss = $style->getStyleSet();
      if (is_object($ss)) {
        $classes = $ss->getCustomClass();
        $classes = $classes ? $classes : '';
        if ($class && strpos($classes,$class) === false) {
          $ss->setCustomClass($classes . ' ' . $class);
          $ss->save();
        }
      }
      if ($name) $block->updateBlockInformation(array('bFilename' => 'supermint_' . $name . '.php'));
    }
  }
}
