<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$th = Loader::helper('text');

echo "\n<div class='nav-pane'> <!-- pane-$j '<span>' . $ni->name . '</span>' -->\n";
if($o->display_pane_title) :
	echo '<h3><a href="' . $ni->url . '">' . '<span>' . $ni->name . '</span>' . '</a></h3>';
endif;
echo '<ul class="l12d row columned">';
	foreach($ni->childrens as $cID) :
		if (array_key_exists($cID,($subNavItems))) :
			$classes = array();
			$ni = $subNavItems[$cID];
			$ni->icon = $ni->cObj->getAttribute('icon') ? '<i class="fa ' . $ni->cObj->getAttribute('icon') . '"></i>' : '<i class="fa ' . $o->default_nav_icon . '"></i> ';
			$desc =  $o->nav_shorten_desc ? $th->shorten($ni->cObj->getCollectionDescription(), $o->nav_shorten_desc ) : $ni->cObj->getCollectionDescription();
			
			//selected
			if ($ni->isCurrent || $ni->inPath)  {
				$selected_level = 1;
			}			 
						
			echo '<li class="' . $ni->classes . '">';
			echo '<a href="' . $ni->url . '" class="lined ' . $ni->classes . '" onfocus="this.blur();">' . $ni->icon . '<span>' . $ni->name . '</span>' . '</a>';
			echo '<p class="desc ' . $ni->classes . '">' . $desc . '</p>';
			echo '</li>';					
		endif;
	endforeach;
echo '</ul>';
echo "\n</div> <!-- /pane-$j -->\n";
