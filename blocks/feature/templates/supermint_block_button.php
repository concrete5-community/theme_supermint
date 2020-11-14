<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$color = $pageTheme->getClassSettings($b,'icon-color');
$color = $color ? "color:#$color" : '';
?>
<a href="<?php  echo $linkURL ?>" class="button-push button-block button-primary">
	 <span class="icon-sizeable">
		 <i class="fa fa-<?php echo $icon?> fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i>
	 </span>
	&nbsp;&nbsp;<?php if ($title) : ?><?php echo $title?><?php endif ?>
	<?php if ($paragraph) : ?><strong><?php echo h($paragraph) ?></strong><?php endif ?>
</a>
