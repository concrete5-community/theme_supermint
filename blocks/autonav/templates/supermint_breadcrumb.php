<?php  
	defined('C5_EXECUTE') or die("Access Denied.");
?>

  <div class="rcrumbs" id="jquery_breadcrumb">
    <ul>
    	
	<?php 
	$navItems = $controller->getNavItems(true);

for ($i = 0; $i < count($navItems); $i++) {
	$ni = $navItems[$i];
	if ($i > 0) {
		//echo '  <i class="icon-angle-right"></i> ';
	}
	
	if ($ni->isCurrent) {
		echo '<li><span>' . $ni->name .'</span></li>';
	} else {
		echo '<li><a href="' . $ni->url . '" target="' . $ni->target . '">' . $ni->name . ' <i class="fa fa-angle-right"></i></a></li>';
	}
}
?>
	</ul>
</div>