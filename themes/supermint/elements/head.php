<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
// Les options
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
?>
<!DOCTYPE html>
<html lang="<?php echo Localization::activeLanguage()?>" class="<?php  echo $o->navigation_style == 'lateral-regular' ? 'with-lateral-nav' : '' ?>">
<head>
<?php echo $html->css($view->getStylesheet('main.less')); ?>
<!-- Start Concrete Header -->
<?php Loader::element('header_required'); ?>
<!-- End Concrete Header -->
<?php if (Loader::helper('concrete/ui')->showWhiteLabelMessage()) :?><style media="screen">body div#ccm-toolbar>ul>li#ccm-white-label-message{display: none !important}</style><?php endif ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo URL::to("/ThemeSupermint/tools/override") . '?cID=' . $c->cID ?>" id="css-override" type="text/css" />
    <?php if (($fontsURL = \Concrete\Package\ThemeSupermint\Controller\Tools\FontsTools::getFontsURL()) !== ''): ?>
        <link rel="stylesheet" href="<?php echo $fontsURL ?>" id="css-fonts" type="text/css" />
    <?php endif; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php if($o->responsive) : ?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php endif ?>
<?php if (is_file(DIR_APPLICATION . '/' . DIRNAME_THEMES . '/supermint/' . DIRNAME_CSS . '/supermint.css')) :?>
<link rel="stylesheet" href="<?php echo DIR_REL . '/' . DIRNAME_APPLICATION . '/' . DIRNAME_THEMES . '/supermint/' . DIRNAME_CSS . '/supermint.css'?>" type="text/css" media="screen" />
<?php endif ?>
<!-- Theme Supermint V<?php echo Package::getByHandle('theme_supermint')->getPackageVersion() ?> // Theme preset ID : <?php echo $o->pID ?> -->
</head>
<body id="supermint"  class="supermint <?php if ($c->isEditMode()) : ?>edit-mode<?php  endif ?>" <?php if ($c->isEditMode()) : ?>style="margin:0 !important;"<?php  endif ?>>
    <!-- Responsive Nav -->
    <?php 
    $responsiveNav = new GlobalArea('Responsive Navigation');
    $responsiveNav->load($c);
    $display_responsiveNav = $responsiveNav->getTotalBlocksInAreaEditMode () > 0 || $responsiveNav->getTotalBlocksInArea() > 0 || $c->isEditMode() ;
    ?>
    <?php if ($display_responsiveNav): ?>
    <div class="<?php echo $o->auto_hidde_top_bar ? 'auto-hidde-top-bar' : ''?> small-display-nav-bar inherit-ccm-page">
        <?php $responsiveNav->display()?>
    </div>
    <?php endif; ?>
    <!-- End Responsive Nav -->
	<div class="<?php echo $c->getPageWrapperClass()?> <?php echo $c->getAttribute('layout_mode') != 'default' && $c->getAttribute('layout_mode') ? $c->getAttribute('layout_mode') : $o->layout_mode ?>">
