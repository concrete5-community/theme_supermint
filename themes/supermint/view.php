<?php  defined('C5_EXECUTE') or die("Access Denied.");

$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$this->inc('elements/header.php');
$this->inc('elements/intro.php');
?>

<main class="full main-container">
	<div class="container">
    <div class="page-content-style padding-<?php echo $o->content_padding ?>">
        <?php $this->inc('elements/ribbon.php') ?>	
		<?php  
						print $innerContent;
						?>			
	</div>
	</div>
</main>	

<?php   $this->inc('elements/bottom.php'); ?>
