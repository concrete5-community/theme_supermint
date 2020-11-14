<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$styleObject = $t->getClassSettingsObject($b,$o->carousel_slidesToShow,$o->carousel_margin);?>

<div class="image-caption-wrapper">
<?php 
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
    if ($altText) {
        $tag->alt(h($altText));
    }
    if ($title) {
        $tag->title(h($title));
    }
    $title = $title ? $title : $f->getTitle();
    $desc = $altText ? $altText : $f->getDescription('description');

    if ($linkURL):
        print '<a href="' . $linkURL . '">';
    endif;?>
    <div class="image-wrapper">
      <?php print $tag ?>
    </div>
    <div class="image-caption">
      <p>
        <strong><?php echo $title  ?></strong> <?php echo $desc ?>
      </p>
    </div>
    <?php


    if ($linkURL):
        print '</a>';
    endif;
    ?>
    </div>
<?php
} else if ($c->isEditMode()) { ?>

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
