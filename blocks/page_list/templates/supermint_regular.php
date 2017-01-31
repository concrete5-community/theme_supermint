<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
			<?php if ($imageTag) : echo $imageTag;  endif ?>
      <?php if ($includeDate): ?>
          <div class="meta">
          	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
          	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
          </div>
      <?php endif; ?>
			<?php if ($includeName): ?><p class="p-title upp bld"><?php  echo $title ?></p><?php endif ?>
			<?php if ($includeDescription): ?><p><?php  echo $description ?></p><?php endif ?>
      <?php if ($useButtonForLink): ?><div class=""><a href="<?php echo $link?>" class="button button-flat"><?php echo $buttonLinkText?></a></div><?php endif; ?>
			<?php echo $popup ?>
		<?php echo $itemCloseTag ?>
	<?php  endforeach ?>
	<?php echo $wrapperCloseTag ?>
	<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

<?php  endif ?>
