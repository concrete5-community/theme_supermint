<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="img-box-hover img-box-hover-light" id="">
    <div class="item">
        <div class="inner">
            <?php if ($image): ?>
                <div class="image-block"><?php echo $image?></div>
            <?php endif; ?>

            <div class="item-description">

                <h4><?php echo h($name)?></h4>

            <?php if ($position && $company && $companyURL): ?>
                <p class="info">
                    <?php echo t('%s, <a href="%s">%s</a>', h($position), ($companyURL), h($company))?>
                </p>
            <?php endif; ?>

            <?php if ($position && !$company && $companyURL): ?>
                <p class="info">
                    <?php echo t('<a href="%s">%s</a>', ($companyURL), h($position))?>
                </p>
            <?php endif; ?>

            <?php if ($position && $company && !$companyURL): ?>
                <p class="info">
                    <?php echo t('%s, %s', h($position), h($company))?>
                </p>
            <?php endif; ?>

            <?php if ($position && !$company && !$companyURL): ?>
                <p class="info">
                    <?php echo h($position)?>
                </p>
            <?php endif; ?>


            <?php if ($paragraph): ?>
                <p class="paragraph"><?php echo h($paragraph)?></>
            <?php endif; ?>

            </div>

        </div>
    </div>
</div>
