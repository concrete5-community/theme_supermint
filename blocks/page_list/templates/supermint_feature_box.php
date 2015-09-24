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
$styleObject = $t->getClassSettingsObject($b);

if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
				<p style="padding: 40px 0px 40px 0px;"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . '</strong>' . t(' disabled in edit mode.') ?></p>
    </div>
<?php else :?>

<?php Loader::PackageElement("page_list/sortable", 'theme_supermint', array('o'=>$o,'tagsObject'=>$tagsObject,'bID'=>$bID,'styleObject'=>$styleObject))?>
<div class="ccm-page-list page-list-masonry row <?php echo $gap ? 'with-gap' : 'no-gap' ?>" data-gridsizer=".icon-table" data-bid="<?php echo $bID?>">
    <?php if ($rssUrl): ?>
        <a href="<?php echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php endif; ?>

	<?php  foreach ($pages as $page):
		$url = $nh->getLinkToCollection($page);
		$title = $url ? ('<a href="' . $url . '">' .$th->entities($page->getCollectionName()) . '</a>') : $th->entities($page->getCollectionName());
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$icon = $page->getAttribute('icon') ? ('<i class="fa fa-2x ' . $page->getAttribute('icon') . '"></i>') : ('<i class="fa fa-2x ' . $o->default_nav_block_icon . '"></i>');
    $tags = isset($tagsObject->pageTags[$page->getCollectionID()]) ? implode(' ',$tagsObject->pageTags[$page->getCollectionID()]) : '';

		if ($includeDescription):
			$description = $page->getCollectionDescription();
			 $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
			$description = $th->entities($description);
		endif;
?>
		<table class="icon-table masonry-item <?php echo $tags ?>">
			<tr>
				<td class="i-icon">
					<?php echo $icon?>
				</td>
				<td <?php if (!$url || ($url && !$useButtonForLink)) : ?>colspan="2"<?php endif ?>>
					<?php if ($title) : ?><h3><?php echo $title?></h3><?php endif ?>
					<?php if ($includeDescription) : ?><p><?php echo h($paragraph) ?></p><?php endif ?>
				</td>
				<?php if ($url && $useButtonForLink) : ?>
				<td style="text-align:right">
					<a href="<?php echo $url ?>" class="button button-flat-primary" target="<?php echo $target ?>"><?php echo $o->feature_link_text ?></a>
				</td>
				<?php endif ?>
			</tr>
		</table>

	<?php  endforeach; ?>
</div><!-- end .ccm-page-list -->

 <?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php endif ?>
