<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

echo "\n<div class='nav-pane'> <!-- pane-$j '<span>' . $ni->name . '</span>' -->\n";
if($o->display_pane_title) :
	echo '<h3><a href="' . $ni->url . '">' . '<span>' . $ni->name . '</span>' . '</a></h3>';
endif;
echo '<ul class="l12 columned">';
//print_r($ni->childrens );
	foreach($ni->childrens as $cID) :
		if (array_key_exists($cID,($subNavItems))) :
			$ni = $subNavItems[$cID];
			$ni->icon = $ni->cObj->getAttribute('icon') ? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '<i class="fa ' . $o->default_nav_icon . '"></i> ';
			
			//selected
			if ($ni->isCurrent || $ni->inPath)  {
				$selected_level = 1;
			}			 
						
			echo '<li class="' . $ni->classes . '">';
			echo '<a href="' . $ni->url . '" class="' . $ni->classes . ' lined" onfocus="this.blur();">' . $ni->icon . '<span>' . $ni->name . '</span>' . '</a>';
			echo '</li>';					
		endif;
	endforeach;
echo '</ul>';
echo "\n</div> <!-- /pane-$j -->\n";
