<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('tiny');
$columns_number = 2;
?>
<div class="ccm-page-list-testimonial">
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
        if ($displayThumbnail) :
	        $img_att = $page->getAttribute('thumbnail');
	        if (is_object($img_att)) :
	        	$img = Core::make('html/image', array($img_att, true));
	        	$imageTag = $img->getTag();
	        	$big = $img_att->getRelativePath();
	        endif;
	    endif;
		$occupation = $page->getAttribute('review_occupation');
		$web = $page->getAttribute('review_website');
		$webUrl = $page->getAttribute('review_website_url');
		$author = $page->getAttribute('review_name');
		$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

		//Other useful page data...
		$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
		
		?>
		<?php if ($key%$columns_number == 0) : ?><div class="row"><?php endif ?>
		<div class="col col-md-<?php echo 12 / $columns_number?> testimonial">
			<div class="">
				<div class="img_wrap">
					<?php if ($displayThumbnail) echo $imageTag ?>
				</div>
				<div class="text">
					<h4><?php  echo $title ?></h4>
					<?php if ($includeDescription) : ?>
					<p class="">
						<i class="icon-quote-left icon-large pull-left"></i>
						<?php echo $description ?>
						<i class="icon-quote-right icon-large pull-right"></i>
					</p>
					<?php endif ?>
					<?php if ($author) : ?><p class="alternate zero"><?php  echo $author ?></p> <?php endif ?>
					<p class="">
					<?php if ($occupation) : ?><span><?php  echo $occupation ?></span> <?php endif ?>
					<?php if ($web) : ?><a href="<?php echo $webUrl ?>"><?php  echo $web ?></a><?php endif ?>
					</p>

				</div>
				<div class="clear"></div>
				<!-- <a class="button button-flat" href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo t('Read more..') ?> <i class="icon-arrow-right"></i></a> -->
			</div>
		</div>
		<?php if ( $key%$columns_number == ($columns_number) - 1 || ($key == count($pages)-1) ) : ?></div><?php endif ?>
	<?php  endforeach; ?>


	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>
</div><!-- end .ccm-page-list -->
