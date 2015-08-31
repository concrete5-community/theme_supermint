<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('file_manager_detail');
?>


<div class="ccm-page-list page-list-block page-list-recent">
	<ul class="zero">
	<?php  foreach ($pages as $key => $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		
		if ($includeDescription):
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		endif;

        $date = date('M d, Y',strtotime($page->getCollectionDatePublic()));
        $original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

        if ($displayThumbnail) :
	        $img_att = $page->getAttribute('thumbnail');
	        if (is_object($img_att)) :
	        	$thumbnailUrl = $img_att->getThumbnailURL($type->getBaseVersion());
	        	$img = Core::make('html/image', array($img_att, true));
	        	$imageTag = $img->getTag();
	        endif;	
	    endif;
		?>
		
		<li class="post">
			<a href="<?php  echo $url ?>">
				<div class="photo" style="background-image:url(<?php echo $thumbnailUrl ?>)">
				</div>
				<div class="desc">
					<h6><?php echo $title ?></h6>
					<?php if ($includeDate): ?><small class="light"><i class="fa fa-calendar-o"></i> <?php echo $date ?></small><?php endif ?>
				</div>
			</a>
		</li>		
		
	<?php  endforeach; ?>
	</ul>
</div><!-- end .ccm-page-list .row-->
<div class="ccm-pagination">
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>		
</div>
