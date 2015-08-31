<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

foreach ($navItems as $ni) {
	$classes = array();

	if ($ni->isCurrent || $ni->inPath) {
		//class for the page currently being viewed
		$classes[] = 'active';
	}

	$ni->style = $ni->cObj->getAttribute('main_page_color') ? ' style="border-color:' . $ni->cObj->getAttribute('main_page_color') . '"' : '';
	$ni->icon = $ni->cObj->getAttribute('icon') ? '<i class="fa fa-fw ' . $ni->cObj->getAttribute('icon') . '"></i>' : '<i class="fa ' . $o->default_nav_block_icon . '"></i>';
	$ni->n = $ni->cObj->getNumChildren() ? '<em>' . $ni->cObj->getNumChildren() .'</em>' : '';



	//Put all classes together into one space-separated string
	$ni->classes = implode(" ", $classes);
}


//*** Step 2 of 2: Output menu HTML ***/

echo '<div class="boxed-c">'; //opens the top-level menu

foreach ($navItems as $ni) {

	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '"' . $ni->style . '>' . $ni->icon . $ni->name . $ni->n . '</a>';
}

echo '</div>'; //closes the top-level menu
?>
