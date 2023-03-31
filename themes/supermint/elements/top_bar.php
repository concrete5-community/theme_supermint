<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$col_logo = $o->logo_col_size ? (int)$o->logo_col_size : 8;
$col_right = 12 - $col_logo;
?>
<?php if ($o->display_top_bar_area) : ?>
	<div id="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-sm-<?php echo $col_logo?> <?php echo $o->display_main_logo_on_mobile ? '' : 'hidden-mobile' ?> " id="logo">
					<?php 
					   $ga = new GlobalArea('Logo');
					   $ga->display();
					?>
				</div>
				<div class="col-sm-<?php echo $col_right?>" id="header-right">
					<?php 
					   $ga = new GlobalArea('Header Right');
					   $ga->display();
					   $a = new Area('Header Right Local');
					   $a->display($c);
					?>
				</div> <!-- .col-md-3 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
		<?php if ($o->display_top_area) : ?>
			<div class="full-top-bar">
		<?php 
		   $ga = new Area('Top Bar');
		   $a->enableGridContainer();
		   $ga->display($c);
		?>
		</div>
		<?php endif ?>
	</div> <!-- .top-bar -->
<?php endif ?>
