<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

$this->inc('elements/header.php');
?>
<div id="middle_unbordered" class="unbordered">
	<div id="top-page">
		<div class="container" id="">
			<div class="row">
				<div class="col-md-12" id="page-top-unbordered">
					<div class="row">
						<div class="col-md-3 title">
							<?php if($o->display_page_title) : ?><h3 class="alternate left"><?php echo $c->getCollectionName() ?></h3><?php else : ?>&nbsp <?php endif ?>
						</div>
						<div class="col-md-5 desc">
							<?php if($o->display_page_desc) : ?><p class="tiny"><?php echo $c->getCollectionDescription() ?></p><?php else : ?>&nbsp <?php endif ?>
						</div>
						<?php if($o->display_breadcrumb) : ?>
						<div class="col-md-4 bread">
							<?php
								$bt_main = BlockType::getByHandle('autonav');
								$bt_main->controller->displayPages = 'top';
								$bt_main->controller->orderBy = 'display_asc';                  
								$bt_main->controller->displaySubPages = 'relevant_breadcrumb';
								$bt_main->controller->displaySubPageLevels = 'enough';
								$bt_main->render('templates/supermint_breadcrumb');			
							?>					
						</div> <!-- .col-md-4 -->
						<?php endif ?>
					</div> <!-- .row -->
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- #top-page -->
	<div id="header_unbordered">
	<?php 
		/// Magic Header ////
		Loader::model('countable_area', 'theme_supermint');
		$options = array('areaName' => 'Header', 'span' => '');
		$header = new CountableArea($options['areaName']);
		if ($c->isEditMode()) :
		
			$this->inc('elements/header_area.php',$options);
		
		elseif ($header->getTotalBlocksInArea($c) > 0 ) :
			if ($c->getAttribute('easy_slider') ) {
				$this->inc('elements/easy_slider.php',$options);
			} else {
				$this->inc('elements/header_area.php',$options);
			}
		endif;
		/// / Magic Header ////
	?>
		<div id="under_header_unbordered">
			<div class="container">
				<!-- <div class="row"> -->
				<?php 
				$a = new Area('Under_header');
				$a->display($c);
				?>	
				<!-- </div> <!-- .row -->						
			</div> <!-- .container -->
		</div>	<!-- .under_header_unbordered -->
	</div> <!-- #header_unbordered -->

	<!-- End header -->
	
	<div id="main_unbordered">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php 
						print $innerContent;
					?>							
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->			
		</div> <!-- .container -->			
	</div> <!-- #main_unbordered -->
	
	<!-- Under main unbordered -->
	
	<div id="under_main_unbordered">	
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php 
					$a = new Area('Under Main');
					$a->display($c);
					?>						
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->			
		</div> <!-- .container -->			
	</div> <!-- .under_main_unbordered -->
</div> <!-- #middle -->



<?php   $this->inc('elements/footer.php'); ?>