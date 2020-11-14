<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$t =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$styleObject = $t->getClassSettingsObject($b);

if (is_object($f)) :
	$fv = $f->getVersion();
    $path = $fv->getRelativePath();
    if ($styleObject->displayTitle) :
	    $title = $title ? $title : $f->getTitle();
	    $desc = $altText ? $altText : $f->getDescription();
	endif;
endif;
$height = $this->controller->maxHeight;
?>
<div class="ccm-intro-block image-wrapper" style=" <?php if ($path) : ?>background-image:url(<?php echo $path ?>)<?php endif?>;<?php if ($height) : ?>height:<?php echo $height ?>px<?php endif ?>">
	<div class="container vertical-align">
		<?php if($title) : ?><h1 class="underline"><?php echo $title ?></h1><?php endif ?>
		<?php if($desc) : ?><h3><?php echo $desc ?></h3><?php endif ?>

	</div>
</div>
