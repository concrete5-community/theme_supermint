<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
// Les options
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$intro = new Area('Intro');
$intro->load($c);
$display_intro = $intro->getTotalBlocksInArea() > 0 || $c->isEditMode() ; // Peut etre ajouter un test pour les page-type
if ($display_intro) :
?>
<section id="intro">
	<div class="container"><?php // I need to add container to wrap with a border ?>
		<div class="row">
			<div class="col-md-12">
				<div class="page-content-style padding-<?php echo $o->content_padding ?>">
			    <?php 
					$a = new Area("Intro");
		            $a->setAreaGridMaximumColumns(12);
					$a->display($c);
				?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
