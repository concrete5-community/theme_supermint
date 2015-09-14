<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
// Les options
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$this->inc('elements/navigation.php');
$header = new Area('Header');
$header->load($c);
$display_header = $header->getTotalBlocksInAreaEditMode () > 0 || $header->getTotalBlocksInArea() > 0 || $c->isEditMode() ;
?>
<header id="header">
    <?php
		$a = new Area("Header Image");
		$a->display($c);
	?>
	<?php if ($display_header) : ?>
	<div id="sub-header">
    <?php
		$header->enableGridContainer();
		$header->display($c);
	?>
	</div>
	<?php endif ?>
</header>
