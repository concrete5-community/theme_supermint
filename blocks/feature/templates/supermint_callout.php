<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="feature-callout">
	<h2> <i class="fa fa-<?php echo $icon?> fa-lg"></i> <?php echo ($paragraph)?>
	<?php  if (isset($linkURL)) : ?>
		<a href="<?php  echo $linkURL ?>" class="button-flat button-primary button-big"><?php echo $title ?></a>
	<?php  endif ?>
	</h2>
</div>
