<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t =  $c->getCollectionThemeObject();
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('tiny');

if ($includeName || $includeDescription || $useButtonForLink) $includeEntryText = true; else $includeEntryText = false;
$styleObject = $t->getClassSettingsObject($b,$o->carousel_slidesToShow,$o->carousel_margin);

if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
			<p style="padding: 40px 0px 40px 0px; color:#999 !important"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . t(' with ') . $styleObject->columns . t(' columns and ') . $styleObject->margin . t('px margin')?> </strong><?php echo  t(' disabled in edit mode.') ?></p>
    </div>
<?php else :


// --- Here start options for columns ---- //
$options = new StdClass();
$options->slidesToShow = $styleObject->columns;
$options->slidesToScroll = $styleObject->columns;
$options->margin = $styleObject->margin;
$options->dots = (bool)$o->carousel_dots;
$options->arrows = (bool)$o->carousel_arrows;
$options->infinite = (bool)$o->carousel_infinite;
$options->speed = (int)$o->carousel_speed;
$options->centerMode = (bool)$o->carousel_centerMode;
$options->variableWidth = (bool)$o->carousel_variableWidth;
$options->adaptiveHeight = (bool)$o->carousel_adaptiveHeight;
$options->autoplay = (bool)$o->carousel_autoplay;
$options->autoplaySpeed = (int)$o->carousel_autoplaySpeed;
$options->nextArrow = '<span class="slick-next-on"><i class="fa fa-angle-right"></i></span>';
$options->prevArrow = '<span class="slick-prev-on"><i class="fa fa-angle-left"></i></span>';

// --- Here stop options for columns ---- //
?>

<div class="ccm-page-list slick-wrapper ccm-page-list-no-gap img-box-hover-light img-box-hover" data-slick='<?php echo json_encode($options) ?>' id="slick-wrapper-<?php echo $bID?>">

	<?php  foreach ($pages as $page):

		$pair = $key % 2 == 1 ? 'pair' : 'impair';
		$url = $nh->getLinkToCollection($page);
		$title_text =  $th->entities($page->getCollectionName());
		$title = $useButtonForLink ? "<a href=\"$url\" target=\"$target\">$title_text</a>" : $title_text;

        $date = date('M / d / Y',strtotime($page->getCollectionDatePublic()));

		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
        $original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

		if ($includeDescription):
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);
		endif;

		$topics = $page->getAttribute($topicAttributeKeyHandle);
        $topics = $page->getAttribute($tagAttributeHandle);
        $topics = is_object($topics)  ? $topics->getOptions() : array();
        if ($displayThumbnail) :
	        $img_att = $page->getAttribute('thumbnail');
	        if (is_object($img_att)) :
	        	$img = Core::make('html/image', array($img_att, true));
	        	$imageTag = $img->getTag();
	        endif;
	    endif;

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
		<div class="slick-slide item">
			<?php if (!$useButtonForLink): ?><a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php endif ?>
			<?php if ($imageTag) : echo $imageTag;  endif ?>
			<?php if ($includeEntryText): ?>
			<div class="info">
	            <?php if ($includeDate): ?>
                <div class="meta">
                	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
                	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
                </div>
	            <?php endif; ?>
				<?php if ($includeName): ?><h4><?php echo $title ?></h4><?php endif ?>
				<?php if ($includeDescription): ?><p><?php  echo $description ?></p><?php endif ?>
	            <?php if ($useButtonForLink): ?><a href="<?php echo $url?>" class="button button-flat"><?php echo $buttonLinkText?></a><?php endif ?>
			</div>
			<?php endif ?>
			<?php if (!$useButtonForLink): ?></a><?php endif ?>
   		</div>

	<?php  endforeach; ?>

</div><!-- end .ccm-page-list -->

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>

<style>
	#slick-wrapper-<?php echo $bID?> .slick-slide {
		margin:0 <?php echo $options->margin ?>px;
	}
	#slick-wrapper-<?php echo $bID?> .slick-next {
		margin-right:<?php echo $options->margin ?>px;
	}
</style>
<?php endif ?>
