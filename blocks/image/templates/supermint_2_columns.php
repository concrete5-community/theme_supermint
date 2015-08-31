<?php defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
if (is_object($f)) {
    if ($maxWidth > 0 || $maxHeight > 0) {
        $im = Core::make('helper/image');
        $thumb = $im->getThumbnail(
            $f,
            $maxWidth,
            $maxHeight
        ); //<-- set these 2 numbers to max width and height of thumbnails
        $tag = new \HtmlObject\Image();
        $tag->src($thumb->src)->width($thumb->width)->height($thumb->height);
    } else {
        $image = Core::make('html/image', array($f));
        $tag = $image->getTag();
    }
    $tag->addClass('ccm-image-block img-responsive bID-'.$bID);
    if ($altText)$tag->alt(h($altText));
    if ($title) $tag->title(h($title));
    
    $title = $title ? $title : $f->getTitle();
    $desc = $altText ? $altText : $f->getDescription('description');
    ?>
    <div class="row image-2-columns">
        <div class="col-md-6">
            <?php if ($title) : ?><h1><?php echo $title ?></h1><?php endif ?>
            <?php if ($desc) : ?><p class="lead"><?php echo $desc ?></p><?php endif ?>
            <?php if ($linkURL) : ?><a href="<?php echo $linkURL ?>" class="button-flat"><?php echo t('More') ?></a><?php endif ?>
        </div>
        <div class="col-md-6">
            <div class="image-wrapper">
               <?php echo $tag ?> 
            </div>
            
        </div>
    </div>
    
<?php } else if ($c->isEditMode()) { ?>

    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Image Block.')?></div>

<?php } ?>

<?php if(is_object($foS)) { ?>	
<script>
$(function() {
    $('.bID-<?php print $bID;?>')
        .mouseover(function(e){$(this).attr("src", '<?php print $imgPath["hover"];?>');})
        .mouseout(function(e){$(this).attr("src", '<?php print $imgPath["default"];?>');});
});
</script>
<?php } ?>
