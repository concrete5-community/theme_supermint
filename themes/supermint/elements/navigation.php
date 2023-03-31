<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$this->inc('elements/head.php');		
?>

			<?php $this->inc('elements/top_bar.php'); ?>

			<nav id="header-nav">
			<!-- disable_embed_nav : <?php var_export($o->disable_embed_nav) ?> -->
			<?php if (!$o->disable_embed_nav) : ?>
			<!-- Navigation type : <?php echo $c->getAttribute('supermint_navigation_type') ?> -->
		    <?php 
			    $bt_main = BlockType::getByHandle('autonav');
			    $bt_main->controller->displayPages = 'top';
			    $bt_main->controller->orderBy = 'display_asc';                  
			    $bt_main->controller->displaySubPages = 'all';
			    $bt_main->controller->displaySubPageLevels = 'all';
			    if ($o->navigation_style == 'slide') 
			    	$bt_main->render('templates/supermint');
			    elseif ($o->navigation_style == 'lateral-regular')
			    	$bt_main->render('templates/supermint_lateral');
			    else
			    	$bt_main->render('templates/supermint_dropdown');

			else :?>
			<nav id="header-nav">
				<?php 
				 $ga = new GlobalArea('Header Nav');
				 $ga->display();
				 ?>
			</nav><!-- #top_nav -->
			<?php endif	?>	
			</nav> <!-- #top -->