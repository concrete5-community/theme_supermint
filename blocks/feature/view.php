<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$title = $linkURL ? ('<a href="' . $linkURL . '">' . h($title) . '</a>') : h($title);
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

?>
<div class="feature-box full">
<table>
	<tr>
		<td class="i-icon">
			<i class="fa fa-<?php echo $icon?>"></i>
		</td>
		<td <?php if (!$linkURL) : ?>colspan="2"<?php endif ?>>
			<?php if ($title) : ?><h3><?php echo $title?></h3><?php endif ?>
			<?php if ($paragraph) : ?><p><?php echo h($paragraph) ?></p><?php endif ?>
		</td>
		<?php if ($linkURL) : ?>
		<td style="text-align:right">
			<a href="<?php echo $linkURL ?>" class="button button-flat-primary" target="_blank"><?php echo $o->feature_link_text ?></a>
		</td>
		<?php endif ?>
	</tr>
</table>
</div>
