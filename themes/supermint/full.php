<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$this->inc('elements/header.php');
$this->inc('elements/intro.php');
?>

<main class="full main-container">
	<div class="container">
    <div class="page-content-style padding-<?php echo $o->content_padding ?>">
        <?php $this->inc('elements/ribbon.php') ?>	
		<?php $this->inc('elements/multiple_area.php',array('c'=>$c,'area_name'=>'Main','AreaGridMaximumColumns' => 12, 'attribute_handle'=>'number_of_main_areas'));  ?>		
	</div>
	</div>
</main>	

<?php   $this->inc('elements/bottom.php'); ?>