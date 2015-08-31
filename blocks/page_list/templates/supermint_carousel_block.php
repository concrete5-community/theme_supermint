<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t = new \Concrete\Package\ThemeSupermint\Src\Helper\SupermintTheme();
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
$options->speed = $o->carousel_speed;
$options->centerMode = (bool)$o->carousel_centerMode;
$options->variableWidth = (bool)$o->carousel_variableWidth;
$options->adaptiveHeight = (bool)$o->carousel_adaptiveHeight;
$options->autoplay = (bool)$o->carousel_autoplay;
$options->autoplaySpeed = $o->carousel_autoplaySpeed;

// --- Here stop option for columns ---- //
?>

<div class="ccm-page-list slick-wrapper page-list-block magnific-wrapper" data-delegate=".popup" data-slick='<?php echo json_encode($options) ?>' id="slick-wrapper-<?php echo $bID?>">

	<?php  foreach ($pages as $page):

		$pair = $key % 2 == 1 ? 'pair' : 'impair';
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
        $date = date('M / d / Y',strtotime($page->getCollectionDatePublic()));
        $original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;

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
	        	$big = $img_att->getRelativePath();
	        endif;
	    endif;

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
			<div class="slick-slide item">
				<div class="media-wrap">
					<?php if ($imageTag) : echo $imageTag;  endif ?>
					<div class="hovercover">
							<a href="<?php  echo $url ?>" class="" title="<?php echo $title ?>" target="<?php  echo $target ?>">
								<span class="fa-stack icon-stack p-link">
								  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
								  <i class="fa-stack-1x fa-inverse fa fa-link icon-light"></i>
								</span>
							</a>
							<a href="<?php echo $big ?>" class="popup">
								<span class="fa-stack icon-stack i-link">
								  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
								  <i class="fa-stack-1x fa-inverse fa fa-picture-o icon-light"></i>
								</span>
							</a>
						</div>
				</div>
            <?php if ($includeDate): ?>
                <div class="meta">
                	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
                	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
                </div>
            <?php endif; ?>
				<a href="<?php  echo $url ?>">
					<div class="item-description">
						<p><?php echo $title ?></p>
						<?php if($includeDescription): ?><span><?php echo $description ?></span><?php endif ?>
					</div>
				</a>
			</div>
	<?php  endforeach; ?>

</div><!-- end .ccm-page-list -->
<style>
	#slick-wrapper-<?php echo $bID?> .slick-slide {
		margin:0 <?php echo $options->margin ?>px;
	}
	#slick-wrapper-<?php echo $bID?> .slick-next {
		/*margin-right:<?php echo $options->margin ?>px;*/
	}
</style>
<?php endif ?>
