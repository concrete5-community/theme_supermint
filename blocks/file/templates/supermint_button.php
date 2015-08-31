<?php  defined('C5_EXECUTE') or die("Access Denied.");
$f = $controller->getFileObject();
$fp = new Permissions($f);
if ($fp->canViewFile()) {
	$c = Page::getCurrentPage();
	if($c instanceof Page) {
		$cID = $c->getCollectionID();
	}
	?>
	<a class="button-flat button-primary" href="<?php echo View::url('/download_file', $controller->getFileID(),$cID) ?>"><i class="fa fa-download"></i> <?php echo stripslashes($controller->getLinkText()) ?></a>
	


<?php } ?>