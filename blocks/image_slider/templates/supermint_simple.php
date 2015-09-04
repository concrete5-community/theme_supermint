<?php defined('C5_EXECUTE') or die("Access Denied.");
$navigationTypeText = ($navigationType == 0) ? 'arrows' : 'pages';
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
if ($c->isEditMode()) :
    $templateName = $controller->getBlockObject()->getBlockFilename();
    $type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle('file_manager_detail');
    ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
        <div style="padding: 40px 0px 40px 0px"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) ?></strong><?php echo t(' disabled in edit mode.')?>
        <?php if(count($rows) > 0) : foreach($rows as $row) : $f = File::getByID($row['fID']); if(is_object($f)) : ?>
        <img src="<?php echo $f->getThumbnailURL($type->getBaseVersion()) ?>" class="edit-mode-thumb" alt="">
        <?php endif; endforeach; endif ?>
        </div>
    </div>
<?php elseif(count($rows) > 0) : ?>
<div class="transit" id="transit-<?php echo $bID?>">
    <section>
        <div id="component" class="component component-fullwidth <?php echo $o->image_slider_effect ?>" >
            <ul class="itemwrap" style="height:0">
                 <?php foreach($rows as $key => $row) :
                    $f = File::getByID($row['fID']);
                    if(is_object($f)) :
                        $tag = Core::make('html/image', array($f, false))->getTag();
                        if($row['title']) $tag->alt($row['title']); else $tag->alt("slide");
                    endif;


                 ?>
                <li <?php if($key == 0) : ?>class="current" <?php endif ?>>
                    <?php if (is_object($f)):?><div class="image-wrapper"><?php echo $tag; ?></div><?php endif?>
                    <div class="caption-wrapper container absolute-container vertical-align">
                        <?php if($row['title']) : ?><h1><?php echo $row['title'] ?></h1><?php endif ?>
                        <?php if ($row['description']) : ?><div></div><?php echo $row['description'] ?><?php endif ?>
                        <?php if($row['linkURL']) : ?><a href="<?php echo $row['linkURL'] ?>" class="mega-link-overlay"></a><?php endif ?>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
            <nav class="transit-nav container absolute-container">
                <a class="prev" href="#"><i class="fa fa-angle-left"></i></a>
                <a class="next" href="#"><i class="fa fa-angle-right"></i></a>
            </nav>
        </div>
    </section>
</div><!-- /transit -->
<script type="text/javascript">
    $(document).ready(function(){

    })
</script>
<?php else : ?>
<div class="ccm-image-slider-placeholder">
    <p><?php echo t('No Slides Entered.'); ?></p>
</div>
<?php endif ?>
