<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>
<a href="<?php  echo $linkURL ?>" class="button-push button-block button-primary">
	 <i class="fa fa-<?php echo $icon?> fa-lg"></i>
	&nbsp;&nbsp;<?php if ($title) : ?><?php echo $title?><?php endif ?>
	<?php if ($paragraph) : ?><strong><?php echo h($paragraph) ?></strong><?php endif ?>
</a>

