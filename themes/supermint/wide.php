<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
$this->inc('elements/intro.php');
?>

<main class="full main-container">
        <?php $this->inc('elements/ribbon.php') ?>	
		<?php $this->inc('elements/multiple_area.php',array('c'=>$c,'area_name'=>'Main','attribute_handle'=>'number_of_main_areas'));  ?>		
</main>	

<?php   $this->inc('elements/bottom.php'); ?>