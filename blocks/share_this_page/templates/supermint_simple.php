<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<p class="share-this-page">
    <?php foreach($selected as $service) { ?>
        <a href="<?php echo $service->getServiceLink()?>"><?php echo $service->getServiceIconHTML()?></a>
    <?php } ?>
</p>