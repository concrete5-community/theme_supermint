<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages,array('additionalWrapperClasses' => array('img-box-hover','page-list-block'))));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
				<a href="<?php echo $url ?>" target="<?php echo $target ?>">
					<div class="icon-block">
						<i class="fa <?php echo $page->getAttribute('icon') ?> fa-inverse fa-3x"></i>
					</div>
					<div class="item-description">
						<h4><?php echo $title ?></h4>
						<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
					</div>
          <?php if ($useButtonForLink): ?><div class="center"><a href="<?php echo $url?>" class="button button-flat"><?php echo $buttonLinkText?></a></div><?php endif; ?>
		    </a>
				<?php echo $popup ?>
			<?php echo $itemCloseTag ?>
		<?php  endforeach ?>
		<?php echo $wrapperCloseTag ?>
		<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

	<?php  endif ?>
