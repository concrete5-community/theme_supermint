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
<div class="icooon-box icooon-box_content">
	<h3 class="icooon-box_icon">
		<span class="fa-stack <?php echo $size ?>">
		  <i class="fa fa-circle fa-stack-2x fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i>
		  <i class="fa fa-<?php echo $icon?> fa-contrast fa-stack-1x" <?php echo $color ? "style='$contrast'" : ''; ?>></i>
		</span>
	</h3>
	<h3 class="icooon-box_content_title"><?php echo $title ?></h3>
	<?php if ($paragraph) : ?><p><?php echo $paragraph?></p><?php endif ?>
</div>
