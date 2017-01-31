<?php defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Block\View\BlockView;
$c = Page::getCurrentPage();
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$cp = new Permissions($c);

if ($includeName || $includeDescription || $useButtonForLink) $includeEntryText = true; else $includeEntryText = false;
$styleObject = $t->getClassSettingsObject($b,$o->stack_carousel_slidesToShow,$o->stack_carousel_margin);

if ($c->isEditMode()) : ?>
	<?php $templateName = $controller->getBlockObject()->getBlockFilename() ?>
    <div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
        <p style="padding: 40px 0px 40px 0px; color:#999 !important"><strong><?php echo  ucwords(str_replace('_', ' ', substr( $templateName, 0, strlen( $templateName ) -4 ))) . t(' with ') . $styleObject->columns . t(' columns and ') . $styleObject->margin . t('px margin')?> </strong><?php echo  t(' disabled in edit mode.') ?></p>
    </div>
<?php else :


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
if (is_array($blocks) && count($blocks)):
// --- Here start otpion for Slick ---- //
$options = new StdClass();
$options->slidesToShow = $styleObject->columns;
$options->slidesToScroll = $styleObject->columns;
$options->margin = $styleObject->margin;
$options->dots = (bool)$o->stack_carousel_dots;
$options->arrows = (bool)$o->stack_carousel_arrows;
$options->infinite = (bool)$o->stack_carousel_infinite;
$options->speed = (int)$o->stack_carousel_speed;
$options->adaptiveHeight = (bool)$o->stack_carousel_adaptiveHeight;
$options->autoplay = (bool)$o->stack_carousel_autoplay;
$options->autoplaySpeed = (int)$o->stack_carousel_autoplaySpeed;

	?>
<div class="sm-stack-slider slick-wrapper" data-slick='<?php echo json_encode($options) ?>' id="slick-wrapper-<?php echo $bID?>">
	<?php foreach ($blocks as $key => $block) :
	$bv = new BlockView($block); ?>
	<div class="slick-slide">
		<div class='content-inner'><?php echo $bv->render('view') ?></div>
	</div>
	<?php endforeach ?>
</div>
<?php endif ?>
<?php endif ?>
