<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

// We are here in the right wrapper for both slider and dropdown

$layout = array();
$k = 0;
use Concrete\Core\Block\View\BlockView;
/*
 *	We will construct the layout based on blocks name
 */
foreach ($ni->blocks as $n => $block) :
	$bv = new BlockView($block);
	$bv->title = $block->getBlockName() ? $block->getBlockName() : '';

	if (stripos($block->title, '-before-') === 0) :
		$bv->title = str_replace('-before-', '', $block->title);
		$layout['header'][] = $bv;
	elseif (stripos($block->title, '-follow-') === 0) :
		$bv->title = str_replace('-follow-', '', $block->title);
		$layout['columns'][$k][] = $bv;
	elseif (stripos($block->title, '-after-') === 0) :
		$bv->title = str_replace('-after-', '', $block->title);
		$layout['footer'][] = $bv;
	else :
		$k ++;
		$layout['columns'][$k][] = $bv;
	endif;
endforeach?>
<div class='nav-pane stack-pane absolute-container' style="padding:20px; <?php if(!$o->full_width_mega) : ?>width:<?php echo (intval(count($layout['columns']) * $o->mega_columns_width)) ?>px<?php endif ?>">

<?php

/*
 *	If they are blocks for the header full width
 */

if (isset($layout['header'])):
	echo '<div class="row">';
	foreach ($layout['header'] as $block) {
		// On affiche le titre et le bloc;
		echo '<div class="col-md-12 stack-header">';
		echo ($block->title && $o->display_title_mega_menu) ? ('<h5 class="stack-title">' . $block->title . '</h4>') : null;
	 	$block->render('view');
	 	echo '</div> <!-- col-md-12 -->';
	}
	echo '</div> <!-- row -->';
endif;

/*
 *	If they are blocks for columns in the middle
 */

if (isset($layout['columns'])):
	$span = 'col-md-' . (intval( 12 / (count($layout['columns']))));
	echo '<div class="row">';
	// SI il y avait un header on le sépare
	if (isset($layout['header'])) echo '<hr class="dashed">';
	foreach ($layout['columns'] as $columns) {
		echo '<div class="' . $span . ' stack-column">';
		foreach ($columns as $block) {
			echo ($block->title && $o->display_title_mega_menu) ? ('<h5 class="stack-title">' . $block->title . '</h4>') : null;
		 	$block->render('view');
		}
	 	echo '</div> <!-- .' . $span . '-->';
	}
	echo '</div> <!-- row -->';
endif;


/*
 *	If they are blocks for the footer full width
 */

if (isset($layout['footer'])):
	echo '<div class="row">';
	if (isset($layout['columns'])) echo '<hr class="dashed">';
	foreach ($layout['footer'] as $n => $block) {
		// On affiche le titre et le bloc;
		echo '<div class="col-md-12 stack-footer">';
		echo ($block->title && $o->display_title_mega_menu) ? ('<h5 class="stack-title">' . $block->title . '</h4>') : null;
	 	$block->render('view');
	 	echo '</div>';
	}
	echo '</div> <!-- row -->';
endif;

echo "</div><!-- stack-pane -->";
