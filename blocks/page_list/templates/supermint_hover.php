<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages,array('additionalWrapperClasses'=>array('page-list-block'))));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
			<?php if (!$useButtonForLink): ?><a <?php echo $to ?>><?php endif ?>
			<?php if ($imageTag) : echo $imageTag;  endif ?>
			<?php if ($includeEntryText): ?>
			<div class="info">
				<div class="vertical-align">
          <?php if ($includeDate): ?>
            <div class="meta">
            	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
            	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
            </div>
          <?php endif; ?>
					<?php if ($includeName): ?><h4><?php echo $title ?></h4><?php endif ?>
					<?php if ($includeDescription): ?><p><?php  echo $description ?></p><?php endif ?>
		      <?php if ($useButtonForLink): ?><a <?php echo $link ?> class="button-primary button-flat button-tiny"><?php echo $buttonLinkText?></a><?php endif ?>
				</div>
			</div>
			<?php endif ?>
			<?php if (!$useButtonForLink): ?></a><?php endif ?>
				<?php echo $popup ?>
			<?php echo $itemCloseTag ?>
		<?php  endforeach ?>
		<?php echo $wrapperCloseTag ?>
		<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

	<?php  endif ?>
