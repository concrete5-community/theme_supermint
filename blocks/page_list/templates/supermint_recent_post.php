<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = $c->getCollectionThemeObject();
extract ($pageTheme->getPageListVariables($b,$controller,$pages,array('itemTag'=>'li','additionalItemClasses'=> array('post'))));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
	echo '<ul class="zero">';
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
			<a href="<?php  echo $url ?>">
				<div class="photo" style="background-image:url(<?php echo $thumbnailUrl ?>)">
				</div>
				<div class="desc ">
					<h6><?php echo $title ?></h6>
					<?php if ($includeDate): ?><small class="light"><i class="fa fa-calendar-o"></i> <?php echo $date ?></small><?php endif ?>
				</div>
			</a>
			<?php echo $popup ?>
		<?php echo $itemCloseTag ?>
	<?php  endforeach ?>
	</ul>
	<?php echo $wrapperCloseTag ?>
	<?php Loader::PackageElement("page_list/utils", 'theme_anitya', array('b'=>$b,'controller' => $controller,'pages'=>$pages))?>
<?php  endif ?>
