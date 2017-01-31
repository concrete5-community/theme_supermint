<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$color = $pageTheme->getClassSettings($b,'icon-color');
$color = $color ? "color:#$color" : '';
$paragraph = $linkURL ? ('<a href="' . $linkURL . '">' . strip_tags($paragraph) . '</a>') : strip_tags($paragraph);
?>
<table class="feature-tiny">
	<tr>
		<td class="icon-sizeable">
			<i class="fa fa-<?php echo $icon?> fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i>
		</td>
		<td>
			<p class="tiny-icooon">
			<?php if ($title) : ?><strong><?php echo strip_tags($title)?></strong><?php endif ?>
			<?php if ($paragraph) : ?><?php echo $paragraph ?><?php endif ?>
			</p>
		</td>
	</tr>
</table>
