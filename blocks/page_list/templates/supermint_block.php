<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
			<div class="media-wrap">
				<?php if ($imageTag) :  echo $imageTag ?>
				<div class="hovercover magnific-wrapper" data-delegate=".popup">
					<a <?php echo $to ?>>
						<span class="fa-stack icon-stack p-link">
						  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
						  <i class="fa-stack-1x fa-inverse fa fa-link icon-light"></i>
						</span>
					</a>
					<a href="<?php echo $imageUrl ?>" class="popup" title="<?php echo $name ?>">
						<span class="fa-stack icon-stack i-link">
						  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
						  <i class="fa-stack-1x fa-inverse fa fa-picture-o icon-light"></i>
						</span>
					</a>
				</div>
			<?php else : ?>
				<div class="placeholder"></div>
			<?php endif ?>
			</div>
		<?php if ($includeEntryText): ?>
    <?php if ($includeDate): ?>
        <div class="meta">
        	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
        	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
        </div>
    <?php endif; ?>
			<a <?php echo $to ?>>
				<div class="item-description">
					<?php  if ($includeName): ?><p><?php  echo $title ?></p><?php  endif ?>
					<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
				</div>
			</a>
		<?php endif; ?>
		<?php echo $popup ?>
	<?php echo $itemCloseTag ?>
<?php  endforeach ?>
<?php echo $wrapperCloseTag ?>
<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

<?php  endif ?>
