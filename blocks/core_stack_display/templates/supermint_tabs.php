<?php defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Block\View\BlockView;

$c = Page::getCurrentPage();
$cp = new Permissions($c);
if ($cp->canViewPageVersions()) {
	$stack = Stack::getByID($stID);	
} else {
	$stack = Stack::getByID($stID, 'ACTIVE');
}
if (is_object($stack)) { 
	$ax = Area::get($stack, STACKS_AREA_NAME);
	$axp = new Permissions($ax);
	if ($axp->canRead()) {
        $ax->disableControls();
		$blocks = $ax->getAreaBlocksArray();
	}
}
if (is_array($blocks) && count($blocks)): ?>
<div class="sm-tabs clearfix">
    <ul class="tabs-menu">
    	<?php foreach ($blocks as $key => $block) :
    	$bv = new BlockView($block);
    	$views[] = $bv;
    	 ?>
        <li <?php echo $key == 0 ? 'class="current"' : '' ?>><a href="#<?php echo $bID . t('-tab-') . $key?>"><?php echo $block->getBlockName() ? $block->getBlockName() : t('Title ') . $key ?></a></li>
        <?php endforeach ?>
    </ul>
    <div class="tab">    
	<?php foreach ($views as $key => $bv) :
		// $bv = new BlockView($block); ?>
		<div id="<?php echo $bID . t('-tab-') . $key ?>" class="tab-content" <?php echo $key == 0 ? 'style="display:block"' : '' ?>>
			<div class="inner clearfix">
				<?php echo $bv->render('view') ?>
			</div>
		</div>
	<?php endforeach ?>
	</div>
</div>
<?php endif ?>