<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages,array('additionalWrapperClasses'=>array('page-list-block'))));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
			<a <?php  echo $link ?> class="button button-flat button-block button-big button-center button-primary"><i class="fa <?php echo $page->getAttribute('icon') ?> fa-inverse fa-2x"></i></a>
				<div class="item-description">
					<?php if ($includeName): ?><p><?php echo $title ?></p><?php endif ?>
					<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
				</div>
				<?php echo $popup ?>
			<?php echo $itemCloseTag ?>
		<?php  endforeach ?>
		<?php echo $wrapperCloseTag ?>
		<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

	<?php  endif ?>
