<?php  defined('C5_EXECUTE') or die("Access Denied.");
$f = $controller->getFileObject();
$fp = new Permissions($f);
if ($fp->canViewFile()) {
	$c = Page::getCurrentPage();
	if($c instanceof Page) {
		$cID = $c->getCollectionID();
	}
	?>
	<h6 class="leaders"><i><?php echo stripslashes($controller->getLinkText()) ?></i><i><a  href="<?php echo View::url('/download_file', $controller->getFileID(),$cID) ?>"><?php echo t('Download') ?></a></i></h6>

<?php } ?>
