<?php  defined('C5_EXECUTE') or die(_("Access Denied."));


echo "\n<!-- Start dropdown from drop.php -->\n";
echo "<ul>";
foreach ($navItems as $key => $ni)  {

	// Si on est AVANT les sous menu, on ignore	
 	if($key <= $niKey ) continue;
 	// Si on est APRES les sous menu, on arrete.
	if($ni->level == 1 ) break;
	
	echo '<li class="' . $ni->classes . ( $ni->hasSubmenu ? ' mgm-drop' : '' ) . '">'; //opens a nav item
	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">'  . $ni->icon . ' ' . $ni->name . '</a>';

	if ($ni->hasSubmenu) {
		echo '<ul>'; //open a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		// Si on est au dernier avant la fin, il ne faut pas descendre jusqu'au niveau 0 mais 1
		if($navItems[$key + 1 ]->level == 1 || !isset($navItems[$key + 1 ]) )  $ni->subDepth -- ;
		echo str_repeat('</ul></li>', $ni->subDepth );
	}
}
echo "</ul>";
echo "\n<!-- end dropdown -->\n";
