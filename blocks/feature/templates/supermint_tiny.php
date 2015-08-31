<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$paragraph = $linkURL ? ('<a href="' . $linkURL . '">' . h($paragraph) . '</a>') : h($paragraph);
?>
<table class="feature-tiny">
	<tr>
		<td>
			<i class="fa fa-<?php echo $icon?>"></i>		
		</td>
		<td>
			<p class="tiny-icooon">
			<?php if ($title) : ?><strong><?php echo h($title)?></strong><?php endif ?>
			<?php if ($paragraph) : ?><?php echo $paragraph?><?php endif ?>
			</p>
		</td>
	</tr>
</table>
