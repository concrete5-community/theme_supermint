<?php defined('C5_EXECUTE') or die("Access Denied.");
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$navItems = $controller->getNavItems();
// Global Logo
if($o->display_logo_mobile_nav) $logo = Stack::getByName('Site Logo');

foreach ($navItems as $ni) {
	$classes = array();

	if ($ni->isCurrent || $ni->inPath) {
		//class for the page currently being viewed
		$classes[] = 'active';
	}



	if ($ni->hasSubmenu) {
		//class for items that have dropdown sub-menus
		$classes[] = 'has-submenu';
	}
	$ni->classes = implode(" ", $classes);
}

echo '<div class="' . ( $o->auto_hidde_top_bar ? 'auto-hidde-top-bar ' : '') . 'small-display-nav-bar-inner Fixed">';
if ($logo):
	echo '<span class="nav-logo">';
	$logo->display();
	echo '</span>';
endif;
		if($o->display_searchbox) :
				$p = Page::getByID($o->display_searchbox);
				if (is_object($p)) :
					echo '<div class="searchbox">';
						echo '<form action="' . Loader::helper('navigation')->getCollectionURL($p) . '">';
							echo '<input type="search" name="query" placeholder="' . t('Search') . '"/>';
						echo '</form>';
					echo '</div>';
			endif;
		endif;
		echo '<button id="hamburger-icon" href="#mmenu" title="Menu">
						<span class="line line-1"></span>
			  		<span class="line line-2"></span>
			  		<span class="line line-3"></span>
				</button>';
echo '</div>';
?>
<div class="overlay overlay-contentscale">
		<nav>
			<ul>
<?php foreach ($navItems as $ni) {

	echo '<li class="' . $ni->classes . '">'; //opens a nav item
	$name = (isset($translate) && $translate == true) ? t($ni->name) : $ni->name;
	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" ' .'>' . $name . '</a>';

	if ($ni->hasSubmenu) {
		echo '<ul class="submenu">'; //opens a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		 echo str_repeat('</ul></li>', $ni->subDepth);
	}
}

 echo '</ul></nav></div></div>'; //closes the top-level menu
