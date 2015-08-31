<?php  defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
$previousLinkURL = is_object($previousCollection) ? $nh->getLinkToCollection($previousCollection) : '';
$parentLinkURL = is_object($parentCollection) ? $nh->getLinkToCollection($parentCollection) : '';
$nextLinkURL = is_object($nextCollection) ? $nh->getLinkToCollection($nextCollection) : '';
$previousLinkText = is_object($previousCollection) ? $previousCollection->getCollectionName() : '';
$nextLinkText = is_object($nextCollection) ? $nextCollection->getCollectionName() : '';
?>

<?php  if ($previousLinkURL || $nextLinkURL || $parentLinkText): ?>

<div class="row">
    <div class="col-md-6">
        <?php  if ($previousLabel && $previousLinkURL != ''): ?>
        <small class="loud"><?php  echo $previousLabel?></small>
        <?php  endif ?>
        <?php  if ($previousLinkText): ?>
            <?php  echo $previousLinkURL ? '<a href="' . $previousLinkURL . '">' . $previousLinkText . '</a>' : '<span>' . $previousLinkText . '</span>' ?>
        <?php  endif; ?>        
    </div>
    <div class="col-md-6">
        <span class="pull-right">
            <?php  if ($nextLabel && $nextLinkURL != ''): ?>
                <small class="loud"><?php  echo $nextLabel?></small>
                <?php  echo $nextLinkURL ? '<a href="' . $nextLinkURL . '">' . $nextLinkText . '</a>' : '<span>' . $nextLinkText . '</span>'  ?>
            <?php  endif; ?>            
        </span>
    </div>
</div>

<?php  endif; ?>
