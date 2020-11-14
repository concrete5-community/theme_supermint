<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$color = $pageTheme->getClassSettings($b,'icon-color');
$color = $color ? "color:#$color" : '';

?>
<div class="feature-callout">
	<h2 class="icon-sizeable"><i class="fa fa-<?php echo $icon?> fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i> <?php echo ($paragraph)?>
	<?php  if (isset($linkURL)) : ?>
		<a href="<?php  echo $linkURL ?>" class="button-flat button-primary button-big"><?php echo $title ?></a>
	<?php  endif ?>
	</h2>
</div>
