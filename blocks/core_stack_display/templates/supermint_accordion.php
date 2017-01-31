<?php defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Block\View\BlockView;

$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$open = $pageTheme->getClassSettings($b,'open');

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
<div class="sm-accordion">
	 <dl>
	<?php foreach ($blocks as $key => $block) :
			$bv = new BlockView($block); ?>
       	<dt class="title <?php echo $key === $open ? 'active' : '' ?>">
            <a href=""><i class="fa fa-chevron-circle-right"></i> <?php echo $block->getBlockName() ? $block->getBlockName() : t('Title ') . $key ?></a>
        </dt>
        <dd class="content <?php echo $key === $open ? 'active' : '' ?>" <?php echo $key === $open ? '' : 'style="display:none"' ?>>
			<div class="content-inner clearfix void"><?php echo $bv->render('view') ?></div>
        </dd>
	<?php endforeach ?>
	</dl>
</div>
<?php endif ?>
