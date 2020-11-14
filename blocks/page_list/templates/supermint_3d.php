<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
      <a <?php echo $to ?>><?php if ($imageTag) : echo $imageTag; else:?><div class="placeholder"></div><?php endif ?></a>
				<?php if ($includeDate): ?>
					<div class="meta">
						<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
						<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
					</div>
				<?php endif; ?>
				<?php  if ($includeName): ?><a <?php echo $link ?> class="button-block button-flat button-primary"><?php  echo $name ?></a><?php endif ?>
				<?php  if ($includeDescription): ?><p><?php  echo $description ?></p><?php endif ?>
				<?php if ($useButtonForLink): ?><a <?php echo $to ?>><?php echo $buttonLinkText?></a><?php endif ?>
			<?php echo $popup ?>
		<?php echo $itemCloseTag ?>
	<?php  endforeach ?>
	<?php echo $wrapperCloseTag ?>
	<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>
<?php  endif ?>
