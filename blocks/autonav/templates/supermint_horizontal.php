<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

foreach ($navItems as $ni) {
	$classes = array();

	if ($ni->isCurrent || $ni->inPath) {
		//class for the page currently being viewed
		$classes[] = 'active';
	}
	$ni->icon = ($ni->cObj->getAttribute('icon') && $o->autonav_horizontal_icon)? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '';

	//Put all classes together into one space-separated string
	$ni->classes = implode(" ", $classes);
}


//*** Step 2 of 2: Output menu HTML ***/

echo '<ul class="nav zero simple nav-horizontal">'; //opens the top-level menu

foreach ($navItems as $ni) {

	echo '<li class="' . $ni->classes . '">'; //opens a nav item

	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $ni->icon . '&nbsp;&nbsp;' . $ni->name . '</a>';

	if ($ni->hasSubmenu) {
		echo '<ul>'; //opens a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
	}
}

echo '</ul>'; //closes the top-level menu
?>
