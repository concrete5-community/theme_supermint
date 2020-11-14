<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$color = $pageTheme->getClassSettings($b,'icon-color');
if ($color) {
	$contrast = "color:" . $pageTheme->contrast('#' . $color);
	$color = "color:#$color";
}
$size = $pageTheme->getClassSettings($b,'icon-size');
$size = $size ? "icon-size-$size" : '';
$title = $linkURL ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : h($title);
?>
<div class="feature-tinybox feature-tinybox_content padding-">
	<h4 class="left">
		<span class="fa-stack <?php echo $size ?>">
		  <i class="fa fa-circle fa-stack-2x fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i>
		  <i class="fa fa-<?php echo $icon?> fa-contrast fa-stack-1x" <?php echo $color ? "style='$contrast'" : ''; ?>></i>
		</span>
	</h4>
	<h4 class="feature-tinybox_content_title"><?php if ($title) : ?><?php echo $title?><?php endif ?></h4>
	<p>
		<?php if ($paragraph) : ?><?php echo strip_tags($paragraph)?><?php endif ?>
		<?php  if (isset($options->linkTo)) : ?> <a href="<?php  echo $options->linkTo ?>" class="button button-flat-primary right"><?php  echo html_entity_decode($options->textLink) ?> <i class="fa fa-arrow-right"></i></a><?php  endif ?>
	</p>

</div>
