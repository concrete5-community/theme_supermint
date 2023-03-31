<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$title = $linkURL ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : h($title);
?>
<div class="icooon-box icooon-box_content">
	<h5 class="" style="text-align:center">
  	<i class="fa fa-<?php  echo $icon ?> fa-2x"></i>	</h5>
	<h3 class="icooon-box_content_title"><?php echo $title ?></h3>
	<?php if ($paragraph) : ?><p><?php echo $paragraph?></p><?php endif ?>
</div>


