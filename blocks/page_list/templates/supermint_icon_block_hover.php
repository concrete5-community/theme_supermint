<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = $c->getCollectionThemeObject();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t =  $c->getCollectionThemeObject();
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('tiny');
$tagsObject = $pageTheme->getPageTags($pages);

if ($includeName || $includeDescription || $useButtonForLink) $includeEntryText = true; else $includeEntryText = false;
$styleObject = $t->getClassSettingsObject($b);
$column_class = $styleObject->columns > 3 ? 'col-md-' : 'col-sm-';

if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
				<div style="padding: 40px 0px 40px 0px"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . t(' with ') . $styleObject->columns ?> </strong><?php echo  t(' disabled in edit mode.') ?></div>
    </div>
<?php else :


?>

<?php Loader::PackageElement("page_list/sortable", 'theme_supermint', array('o'=>$o,'tagsObject'=>$tagsObject,'bID'=>$bID))?>


	<div class="ccm-page-list page-list-block page-list-block-static page-list-masonry img-box-hover" id="page-list-img-box-hover-<?php echo $bID?>">
		<!-- <div class="row"> -->
	<?php  foreach ($pages as $key => $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$tags = isset($tagsObject->pageTags[$page->getCollectionID()]) ? implode(' ',$tagsObject->pageTags[$page->getCollectionID()]) : '';

		if ($includeDescription):
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);
		endif;
		$icon = $page->getAttribute('icon') ? $page->getAttribute('icon') : 'fa-dot';
  		?>
		<div class="<?php echo $column_class . intval(12 / $styleObject->columns)?> item masonry-item <?php echo $tags ?>">
			<div class="inner">
				<a href="<?php echo $url ?>" target="<?php echo $target ?>">
					<div class="icon-block">
						<i class="fa <?php echo $icon ?> fa-inverse fa-3x"></i>

					</div>
					<div class="item-description">
						<h4><?php echo $title ?></h4>
						<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
					</div>
		            <?php if ($useButtonForLink): ?>
		            <div class="center">
		                <a href="<?php echo $url?>" class="button button-flat"><?php echo $buttonLinkText?></a>
		            </div>
		            <?php endif; ?>
		        </a>
	        </div>
		</div>
	<?php  endforeach; ?>
	<!--</div><!-- .row -->

</div><!-- end .ccm-page-list .row-->
<div class="ccm-pagination">
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>
</div>
<script>
	$(document).ready(function () {
		$('#page-list-img-box-hover-<?php echo $bID?>').isotope({
		  itemSelector: '.item',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.<?php echo $column_class . intval(12 / $styleObject->columns)?>'
		  }
		})
	});
</script>
<?php endif ?>
