<?php defined('C5_EXECUTE') or die("Access Denied.");
$navigationTypeText = ($navigationType == 0) ? 'arrows' : 'pages';
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$styleObject = $t->getClassSettingsObject($b,$o->image_slider_slidesToShow,$o->image_slider_margin);

if ($c->isEditMode()) :
    $templateName = $controller->getBlockObject()->getBlockFilename();
    $type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('file_manager_detail');
    ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
        <div style="padding: 40px 0px 40px 0px"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . t(' with ') . $styleObject->columns . t(' columns and ') . $styleObject->margin . t('px margin') ?></strong><?php echo t(' disabled in edit mode.')?>
        <?php if(count($rows) > 0) : foreach($rows as $row) : $f = File::getByID($row['fID']); if(is_object($f)) : ?>
        <img src="<?php echo $f->getThumbnailURL($type->getBaseVersion()) ?>" class="edit-mode-thumb" alt="">
        <?php endif; endforeach; endif ?>
        </div>
    </div>
<?php else :
$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('file_manager_detail');

if(count($rows) > 0) :
// --- Here start otpion for Slick ---- //
$options = new StdClass();
$options->slidesToShow = $styleObject->columns;
$options->slidesToScroll = $styleObject->columns;
$options->margin = $styleObject->margin;
$options->dots = (bool)$o->image_slider_dots;
$options->arrows = (bool)$o->image_slider_arrows;
$options->infinite = false;
$options->speed = (int)$o->image_slider_speed;
$options->adaptiveHeight = (bool)$o->image_slider_adaptiveHeight;
$options->autoplay = (bool)$o->image_slider_autoplay;
$options->autoplaySpeed = (int)$o->image_slider_autoplaySpeed;

 ?>
<div class="sm-image-slider slick-wrapper" data-slick='<?php echo json_encode($options) ?>' id="slick-wrapper-<?php echo $bID?>">
    <?php foreach($rows as $row) : ?>
    <div class="slick-slide">
        <?php if($row['linkURL']) : ?>
            <!-- <a href="<?php echo $row['linkURL'] ?>"></a> -->
        <?php endif ?>
        <?php
        $f = File::getByID($row['fID'])
        ?>
        <?php if(is_object($f)) :
            $tag = Core::make('html/image', array($f, false))->getTag();
            if($row['title']) {
                $tag->alt($row['title']);
            }else{
                $tag->alt("slide");
            }
            print $tag; ?>

        <?php endif ?>
        <div class="ccm-image-slider-text content-inner">
            <?php if($row['title']) { ?>
                <h3 class="ccm-image-slider-title"><?php echo $row['title'] ?></h3>
            <?php } ?>
            <?php echo $row['description'] ?>
        </div>
    </div>
    <?php endforeach ?>
</div><!-- #slick-wrapper-<?php echo $bID?> -->
<?php else : ?>
<div class="ccm-image-slider-placeholder">
    <p><?php echo t('No Slides Entered.'); ?></p>
</div>
<?php endif ?>
<?php endif ?>
