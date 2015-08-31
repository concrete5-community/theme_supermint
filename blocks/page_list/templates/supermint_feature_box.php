<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('tiny');
$o = \Concrete\Package\ThemeSuperMint\Src\Models\ThemeSupermintOptions::get();
?>

<div class="ccm-page-list">
    <?php if ($rssUrl): ?>
        <a href="<?php echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php endif; ?>
	<?php  foreach ($pages as $page):

		// Prepare data for each page being listed...
		$url = $nh->getLinkToCollection($page);
		$title = $url ? ('<a href="' . $url . '">' .$th->entities($page->getCollectionName()) . '</a>') : $th->entities($page->getCollectionName());
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$icon = $page->getAttribute('icon') ? ('<i class="fa fa-2x ' . $page->getAttribute('icon') . '"></i>') : ('<i class="fa fa-2x ' . $o->default_nav_block_icon . '"></i>');
		if ($includeDescription):
			$description = $page->getCollectionDescription();
			 $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
			$description = $th->entities($description);	
		endif;
?>
		<table class="icon-table">
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
 
 <?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

</div><!-- end .ccm-page-list -->
