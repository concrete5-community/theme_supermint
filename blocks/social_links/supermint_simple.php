<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div id="ccm-block-social-links<?php echo $bID?>" class="ccm-block-social-links social-links">
    <ul class="list-inline">
    <?php foreach($links as $link) {
        $service = $link->getServiceObject();
        ?>
        <li><a href="<?php echo $link->getURL()?>"><?php echo $service->getServiceIconHTML()?></a></li>
    <?php } ?>
    </ul>
</div>
