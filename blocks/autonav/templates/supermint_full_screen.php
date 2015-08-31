<?php defined('C5_EXECUTE') or die("Access Denied.");

$navItems = $controller->getNavItems();
// Global Logo 
$logo = Stack::getByName('Site Logo');

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

?>
<div class="small-display-nav-bar-inner">
<?php if ($logo): ?>
	<span class="nav-logo"><?php $logo->display() ?></span>
<?php endif ?>
	<a id="hamburger-icon" href="#" title="Menu">
	  <span class="line line-1"></span>
	  <span class="line line-2"></span>
	  <span class="line line-3"></span>
	</a>
	<div class="overlay overlay-contentscale">
		<nav>
			<ul>
				<li><a href="<?php echo Loader::helper('navigation')->getLinkToCollection(Page::getByID(1)) ?>"><i class="fa fa-home"></i>
</a></li><?php 
foreach ($navItems as $ni) {

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
