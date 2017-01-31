<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

// Cette requete peut prendre plus d'une demi seconde !
$navItems = $controller->getNavItems();
$c = Page::getCurrentPage();
$time_start = microtime(true);
$prepare_start = microtime(true);
$i = 0;
// Les options
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);

// Global Logo

// Pour les stacks
$c = Page::getCurrentPage();
$cp = new Permissions($c);
$canViewVersion = $cp->canViewPageVersions() ? 'ACTIVE' : null;

// On commence La recherche de classes et de stacks

foreach ($navItems as $niKey => $ni) :

	$classes = array();
	$style = array();

	if ($ni->cObj->getAttribute('main_page_color'))
		$style[] = 'border-bottom-color:' . $ni->cObj->getAttribute('main_page_color');

	if ($ni->isCurrent || $ni->inPath)
		$classes[] = 'active';

	$ni->icon = ($ni->cObj->getAttribute('icon') && $o->first_level_nav_icon) ? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '';


	// Maintenant on va voir si il y a des bloc autorisé dans un stack relatif.
	// Si oui on les definis dans $ni->blocks
	if ($ni->level == 1) :
		$relatedStack = Stack::getByName('mega_menu_' . $ni->cObj->getCollectionHandle(), 'RECENT');
		if (!$relatedStack) $relatedStack = Stack::getByName('mega_menu_' . $ni->cObj->getCollectionID(), 'RECENT');
		if ($relatedStack) :
			$ni->stack = $relatedStack;
		endif;
	endif;

	if ($ni->stack):
		$classes[]  = 'parent deeper stacker';
	elseif ($ni->hasSubmenu) :
		$classes[]  = 'parent deeper';
	endif;

	if ($o->harmonize_title_width_on_lateral_nav ) // Le resultat est assez décevant, trouver un autre script
		$classes[] = 'harmonize-width-heading';

	$ni->classes = implode(" ", $classes);
	$ni->style = implode(";", $style);
endforeach;

?><!-- template supermint_mega.php Prepared nav in <?php echo  microtime(true) - $prepare_start ?>s  -->
<div class="top-nav-lateral">
	<!-- <div class="mobile-handle"><i class="fa fa-navicon"></i></div> -->
	<div class="wrap">
		<div class="top">
			<div class="inner">
				<?php if ($header = Stack::getByName('Lateral Navigation Header')): ?>
				<div class="nav-header"><?php $header->display() ?></div>
				<?php elseif ($logo = Stack::getByName('Site Logo')): ?>
				<div class="nav-logo"><?php $logo->display() ?></div>
				<?php endif ?>

			</div><!-- .inner -->
		</div><!-- .top -->
		<div class="middle">
			<div class="cell">
				<nav class="lateral-nav <?php echo $o->lateral_nav_element_harmonized ? 'harmonize-width-heading' : ''?>">
					<ul class="zero">

<?php
foreach ($navItems as $k=>$ni) :

        echo '<li class="' . $ni->classes . '" >'; //opens a nav item
        echo '<a href="' .   $ni->url . '" target="' . $ni->target . '" style="' . $ni->style . '" >' . ($o->first_level_nav_icon ? $ni->icon : '') . ' ' . $ni->name . '</a>';

        if ($ni->hasSubmenu) {

			if ($ni->stack) :
				echo '<ul class="stack-lateral"><li><div class="stack-lateral-inner">';
						$ni->stack->display();
						echo '<hr>';
				echo '</div></li>';
			else :
				echo '<ul>'; //opens a dropdown sub-menu
			endif;
        } else {
            echo '</li>'; //closes a nav item
            echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
        }

endforeach?>

					</ul>
				</nav>
			</div><!-- .cell -->
		</div><!-- .middle -->
		<div class="bottom">
			<div class="inner">
				<?php
				if($o->display_searchbox) :
					$p = Page::getByID($o->display_searchbox);
					if (is_object($p)) :
				 ?>

					<form action="<?php  echo  Loader::helper('navigation')->getCollectionURL($p)?>" id="expand-search">
				   	   <input type="search" class="col-md-3" id="search-keywords" name="query" placeholder="&#xf002"/>
					</form>
					<?php endif ?>
				<?php endif ?>

				<?php if ($footer = Stack::getByName('Lateral Navigation Footer')): ?>
				<div class="nav-footer"><?php $footer->display() ?></div>
				<?php endif ?>
			</div><!-- .inner -->
		</div><!-- .bottom -->
	</div><!-- .wrap -->
</div><!-- .top-nav-lateral	 -->
