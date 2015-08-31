<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<section class="main-bottom">
<?php 
	$area = new Area("Main Bottom");
	$area->enableGridContainer();
	$area->display($c);    
 ?>	
</section>

<?php $this->inc('elements/footer.php'); ?>