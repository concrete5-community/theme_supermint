<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t = new \Concrete\Package\ThemeSupermint\Src\Helper\SupermintTheme();
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('tiny');

if ($includeName || $includeDescription || $useButtonForLink) $includeEntryText = true; else $includeEntryText = false;
$styleObject = $t->getClassSettingsObject($b);
$column_class = $styleObject->columns > 3 ? 'col-md-' : 'col-sm-';


if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
        <div style="padding: 40px 0px 40px 0px"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . t(' with ') . $styleObject->columns ?> </strong><?php echo  t(' disabled in edit mode.') ?></div>
    </div>
<?php else : ?>


	<div class="ccm-page-list page-list-block page-list-block-static magnific-wrapper" data-delegate=".popup">

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

        $date = date('M / d / Y',strtotime($page->getCollectionDatePublic()));
        $original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

        if ($displayThumbnail) :
	        $img_att = $page->getAttribute('thumbnail');
	        if (is_object($img_att)) :
	        	$img = Core::make('html/image', array($img_att, true));
	        	$imageTag = $img->getTag();
	        	$big = $img_att->getRelativePath();
	        endif;
	    endif;
		?>
		<?php if ($key%$styleObject->columns == 0) : ?><div class="row"><?php endif ?>
		<div class="<?php echo $column_class . intval(12 / $styleObject->columns)?> item">
			<div class="media-wrap">
				<?php if ($imageTag) :  echo $imageTag ?>
				<!-- <div class="mediaholder"> -->
				<div class="hovercover">
					<a href="<?php  echo $url ?>" class="" title="<?php echo $title ?>" target="<?php  echo $target ?>">
						<span class="fa-stack icon-stack p-link">
						  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
						  <i class="fa-stack-1x fa-inverse fa fa-link icon-light"></i>
						</span>
					</a>
					<a href="<?php echo $big ?>" class="popup" title="<?php echo $title ?>">
						<span class="fa-stack icon-stack i-link">
						  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
						  <i class="fa-stack-1x fa-inverse fa fa-picture-o icon-light"></i>
						</span>
					</a>
				</div>


			<?php else : ?>
				<div class="fill" style="width:<?php echo 1170 / $styleObject->columns ?>px; height:<?php echo intval ((1170 / $styleObject->columns)) / 1.4 ?>px; background-color:#efefef"></div>
			<?php endif ?>
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
		<?php if ( $key%$styleObject->columns == ($styleObject->columns) - 1 || ($key == count($pages)-1) ) : ?></div><?php endif ?>
	<?php  endforeach; ?>

</div><!-- end .ccm-page-list .row-->
<div class="ccm-pagination">
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>
</div>
<?php endif ?>
