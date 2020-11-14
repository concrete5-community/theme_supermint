<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);


echo "\n<!-- Start Multi columns dropdown -->\n";?>
<?php

$layout = $t->createLayout($navItems, $niKey, $o->break_columns_on_child, $o->nav_multicolumns_item_per_column);

$span = 'col-sm-' . (intval( 12 / (count($layout))));
?>
<div class='multicolumn-pane  <?php if($o->full_width_multicolumn) : ?>absolute-container <?php endif ?>' style="padding:20px; <?php if(!$o->full_width_multicolumn) : ?>width:<?php echo (intval(count($layout) * $o->mega_columns_width)) ?>px<?php endif ?>">
	<div class="row">
<?php
foreach ($layout as $key => $element) :
	echo '<div class="' . $span . ' stack-column">';
	echo '<ul class="mgm-multi-c-column">';
	foreach ($element as $nikey => $ni) :
		echo '<li class="' . $ni->classes . ( $ni->hasSubmenu ? ' mgm-multi-c-title' : '' ) . '">';
		echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">'  . $ni->icon . ' ' . $ni->name . '</a>';
		echo '</li>'; //closes a nav item
	endforeach;
	echo '</ul></div> <!-- .mgm-multi-c-column -->';
endforeach?>
	</div><!-- row -->
</div><!-- stack-pane -->
<?php
 ?>
