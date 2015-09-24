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
$gap = !(in_array('no-gap',$styleObject->classesArray));

if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
				<p style="padding: 40px 0px 40px 0px;"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . '</strong>' . t(' with ') .  $styleObject->columns . t(' columns and ') . ($gap ? t(' regular Gap ') : t('no Gap ')) . t(' disabled in edit mode.') ?></p>
    </div>
<?php else :?>


<?php Loader::PackageElement("page_list/sortable", 'theme_supermint', array('o'=>$o,'tagsObject'=>$tagsObject,'bID'=>$bID,'styleObject'=>$styleObject))?>
	<div class="ccm-page-list page-list-block page-list-block-static page-list-masonry row <?php echo $gap ? 'with-gap' : 'no-gap' ?>" id="page-list-img-box-hover-<?php echo $bID?>" data-gridsizer=".<?php echo $column_class . intval(12 / $styleObject->columns)?>" data-bid="<?php echo $bID?>">
		<!-- <div class="row"> -->
	<?php  foreach ($pages as $key => $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$externalLink = $page->getAttribute('external_link');
		$url = $externalLink ? $externalLink : $nh->getLinkToCollection($page);
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
			<a href="<?php  echo $url ?>" class="button button-flat button-block button-big button-center button-primary"><i class="fa <?php echo $icon ?> fa-inverse fa-2x"></i></a>
				<div class="item-description">
					<p><?php echo $title ?></p>
					<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
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
	$(document).ready(function (argument) {
		$('#ccm-page-list-<?php echo $bID?>').isotope({
		  itemSelector: '.item',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.<?php echo $column_class . intval(12 / $styleObject->columns)?>'
		  }
		})
	});
</script>
<?php endif ?>
