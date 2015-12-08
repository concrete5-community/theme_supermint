<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$navItems = $controller->getNavItems();
// Global Logo
if($o->display_logo_mobile_nav) $logo = Stack::getByName('Site Logo');

foreach ($navItems as $ni) {
	$classes = array();

	if ($ni->isCurrent) {
		//class for the page currently being viewed
		$classes[] = 'Selected';
	}

	if ($ni->inPath) {
		//class for parent items of the page currently being viewed
		$classes[] = 'Selected';
	}

	$ni->icon = ($ni->cObj->getAttribute('icon') && $o->mmenu_display_icon) ? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '';

	/*
	if ($ni->hasSubmenu) {
		//class for items that have dropdown sub-menus
		$classes[] = 'nav-dropdown';
	}
	*/
	$ni->classes = implode(" ", $classes);
}
echo '<div class="' . ( $o->auto_hidde_top_bar ? 'auto-hidde-top-bar ' : '') . 'small-display-nav-bar-inner Fixed">';
if ($logo):
	echo '<span class="nav-logo">';
	$logo->display();
	echo '</span>';
endif;
	echo '<a id="hamburger-icon" class="vertical-align" href="#mmenu" title="Menu">
					<span class="line line-1"></span>
					<span class="line line-2"></span>
					<span class="line line-3"></span>
			</a>';
		if($o->display_searchbox && $o->display_searchbox_mobile) :
				$p = Page::getByID($o->display_searchbox);
				if (is_object($p)) :
					echo '<div class="searchbox vertical-align">';
						echo '<form action="' . Loader::helper('navigation')->getCollectionURL($p) . '">';
							echo '<input type="search" name="query" placeholder="' . t('Search') . '"/>';
						echo '</form>';
					echo '</div>';
			endif;
		endif;
echo '</div>';

if (count($navItems) > 0) :
	echo '<nav id="mmenu">';
    echo '<ul class="">'; //opens the top-level menu

    foreach ($navItems as $ni) {

        echo '<li class="' . $ni->classes . '">'; //opens a nav item
        echo '<a href="' . $ni->url . '" target="' . $ni->target . '">' .  $ni->icon . ' ' . $ni->name . '</a>';

        if ($ni->hasSubmenu) {
            echo '<ul>'; //opens a dropdown sub-menu
        } else {
            echo '</li>'; //closes a nav item
            echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
        }
    }

    echo '</ul>';
	echo '</nav>';
elseif (is_object($c) && $c->isEditMode()) : ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Auto-Nav Block.')?></div>
<?php endif;
