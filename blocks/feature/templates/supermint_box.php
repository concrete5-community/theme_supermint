<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$title = $linkURL ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : h($title);
?>
<div class="feature-box feature-box_content">
	<h3 class="feature-box_icon">
	<span class="fa-stack">
	  <i class="fa fa-circle fa-stack-2x"></i>
	  <i class="fa fa-<?php  echo $icon ?> fa-stack-1x fa-inverse"></i>
	</span>	
	</h3>
	<h3 class="feature-box_content_title"><?php  echo $title ?></h3>
	<?php if ($paragraph) : ?><p><?php echo $paragraph?></p><?php endif ?>
</div>


