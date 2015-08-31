<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$title = $linkURL ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : h($title);
?>
<div class="feature-tinybox feature-tinybox_content padding-">
	<h4 class="left">
		<span class="fa-stack ">
		  <i class="fa fa-circle fa-stack-2x" style="color:<?php  echo $options->mainColor?>;"></i>
		  <i class="fa fa-<?php echo $icon?> fa-inverse fa-stack-1x"></i>
		</span>	
	</h4>
	<h4 class="feature-tinybox_content_title"><?php if ($title) : ?><?php echo $title?><?php endif ?></h4>
	<p>
		<?php if ($paragraph) : ?><?php echo $paragraph?><?php endif ?>
		<?php  if (isset($options->linkTo)) : ?> <a href="<?php  echo $options->linkTo ?>" class="button button-flat-primary right"><?php  echo html_entity_decode($options->textLink) ?> <i class="fa fa-arrow-right"></i></a><?php  endif ?>
	</p>
	
</div>


