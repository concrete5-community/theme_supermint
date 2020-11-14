<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$c = Page::getCurrentPage();
// Cette requete peut prendre plus d'une demi seconde !
$navItems = $controller->getNavItems();

$time_start = microtime(true);
$prepare_start = microtime(true);
$i = 0;
// Les options
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

// Reglage ecommerce
$pc = array();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$pc = array();

// $n est un tableau represantant toutes les cID,
// Peut être utile si il faut gagner de la performance..
foreach ($navItems as $navItem) {
	if ($navItem->level == 1) :
		$l1 = $navItem->cID;
		$navItem->childrens = $navItem->cObj->getCollectionChildrenArray();
	elseif ($navItem->level == 2 ) :
		$l2 = $navItem->cID;
		$n[$l1][$navItem->cID] = array();
		$navItem->childrens = $navItem->cObj->getCollectionChildrenArray();
		$subNavItems[$navItem->cID] = $navItem;
	elseif ($navItem->level == 3 ) :
		$n[$l1][$l2][$navItem->cID] = array();
		$subsubNavItems[$navItem->cID] = $navItem;
	endif;
	// $nObj est plat et contiendra tous les $ni
	// classé par cID.
	// Il suffira de parcourir le tableau $n et de recherher les cID dans $nObj
	// Cela gagnera 0,04s de performance en evitant d'apeller getCollectionChildrenArray()
	$nObj[$navItem->cID] = $navItem;
}


foreach ($navItems as $ni) {

	$classes = array();
	$style = array();

	$ni->style = $ni->cObj->getAttribute('main_page_color') ? ' style="border-bottom-color:' . $ni->cObj->getAttribute('main_page_color') . '"' : '';

	/* ---- STACKS -------
	 * On teste si il y a un stack *
	 * Le stack doit etre nomé de la manière suivnate *
	 * mega_menu_{cID}
	 */

	if($ni->level == 1)	{
		// Maintenant on va voir si il y a des bloc autorisé dans un stack relatif.
		// Si oui on les definis dans $ni->blocks
		// On essaie avec le nom
		$relatedStack = Stack::getByName('mega_menu_' . $ni->cObj->getCollectionHandle(), 'RECENT');
		if (!$relatedStack) $relatedStack = Stack::getByName('mega_menu_' . $ni->cObj->getCollectionID(), 'RECENT');
		if ($relatedStack) :
			$ax = Area::get($relatedStack, STACKS_AREA_NAME);
			$axp = new Permissions($ax);
			if ($axp->canRead()) {
		    $ax->disableControls();
				$ni->blocks  = $ax->getAreaBlocksArray();
			}
		endif;
	}

	if ($ni->isCurrent || $ni->inPath ) {
		//class for the page currently being viewed
		$classes[] = 'active';
	}

	if ($ni->isFirst) {
		//class for the first item in each menu section (first top-level item, and first item of each dropdown sub-menu)
		$classes[] = 'nav-first';
	}

	if ($ni->isLast) {
		//class for the last item in each menu section (last top-level item, and last item of each dropdown sub-menu)
		$classes[] = 'nav-last';
	}
	if ($ni->hasSubmenu) {
		$classes[] = 'has-submenu';
	}
	$ni->icon = ($ni->cObj->getAttribute('icon')) ? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '';

	$ni->classes = implode(" ", $classes);

}
?>
		<!-- template supermint.php - prepared nav in <?php echo  microtime(true) - $prepare_start ?>s  -->
		<div class="regular-top-nav">
			<ul class="nav_tabs">

<?php
foreach ($navItems as $k=>$ni) {

	if($ni->level != 1 ) continue;

	echo '<li class="' . $ni->classes . '">'; //opens a nav item

	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '"' . $ni->style . '>' . ($o->first_level_nav_icon ? $ni->icon : '') . ' ' . $ni->name . '</a>';

	echo '</li>';

	// Si le menu est selectionne ou un de ses enfant
	if ($ni->isCurrent || $ni->inPath) {
		// On recupere lequel est selectionne ou enfant
		$selected_item_index = $i;
	}
	$i ++;
}

	if($o->display_searchbox) :
		$p = Page::getByID($o->display_searchbox);
		if (is_object($p)) :
		echo '<li class="search-in-nav">';
		?>
		<form action="<?php  echo  Loader::helper('navigation')->getCollectionURL($p)?>" id="expand-search">
	   	   <input type="search" class="vertical-align" id="search-keywords" name="query"/>
		</form>
		</li>
		<?php endif ?>
	<?php endif ?>
   </ul>
	</div>

	<div class="container">
		<div class="row">
			<!-- panes -->
			<div class="submenu_panes container <?php echo $is_empty_pane; if (!isset($selected_item_index)) echo  'empty_pane_selected'?>">
				<?php if ($o->nav_slide_arrow): ?>
				<a href="javascript:$.boxNav.close()" class="close"><i class="fa fa-arrow-up fa-lg"></i></a>
				<?php endif ?>
			  	<!-- wrapper for scrollable items -->
				<div  class='nav-panes'>
				<?php
				$j = 0;
				foreach ($navItems as $k => $ni) {
					// on regarde si un stack à été prévu en temps que sous menu.
					if ($ni->blocks) :	?>
						<?php
						Loader::PackageElement("navigation/stack", 'theme_supermint', array(
							'ni' => $ni,
							'o' => $o,
							'classes' => ''
						));
						$j++;
					// Sinon, Si il y a des enfants, on charge le template demandé par l'atrribut
					elseif ($ni->hasSubmenu && $ni->level == 1) :
						switch($ni->cObj->getAttribute('supermint_navigation_type')) {
							case 'Type 1 (L1-2 w desc)':
								$type = 'type1';
								break;
							case 'Type 2 (L1-2-3)':
								$type = 'type2';
								break;
							case 'Type 3 (L1-2)':
								$type = 'type3';
								break;
							case 'Hidden':
								$type = false;
								break;
							default :
								$type = 'type1';
						}
						if ($type) Loader::PackageElement("navigation/$type", 'theme_supermint', array(
							'ni' => $ni,
							'subNavItems' => $subNavItems,
							'subsubNavItems' =>$subsubNavItems,
							'j' => $j,
							'o' => $o
							));

						$j++;

					// On a rien a afficher, donc panneau vide
					elseif ($ni->level == 1) :
						echo "\n<div class='empty_pane nav-pane'> <!-- pane-$j  -->\n";
						echo '&nbsp;'; // The pane is empty
						echo "\n</div> <!-- /pane-$j -->\n";
						$j++;
					endif;

				}
				?>
			</div><!-- .nav-panes -->
		</div> <!-- /#submenu_panes -->
		<div class="clear"></div>
	</div> <!-- .row -->
</div> <!-- .container -->

<?php
$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<!-- Navigation Generated in <?php echo $time ?> secs -->
