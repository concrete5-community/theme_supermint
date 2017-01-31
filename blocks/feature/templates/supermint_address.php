<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$color = $pageTheme->getClassSettings($b,'icon-color');
$color = $color ? "color:#$color" : '';

$cleantitle = ($linkURL) ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : ('<strong>' . h($title) . '</strong>');
$cleantitle = $title ? $cleantitle : '';
?>
<table class="feature-address wide">
	<tr>
		<td class="icon icon-sizeable">
			<i class="fa fa-<?php echo $icon?> fa-colored" <?php echo $color ? "style='$color'" : ''; ?>></i>
		</td>
		<td>
			<p>
				<small>
					<?php if ($cleantitle) : ?><?php echo $cleantitle?><?php if ($paragraph) : ?><br><?php endif ?><?php endif ?>
					<?php if ($paragraph) : ?><?php echo $paragraph?><?php endif ?>
				</small>
			</p>
		</td>
	</tr>
</table>
