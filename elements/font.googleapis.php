<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$time_start = microtime(true);

use \Concrete\Package\ThemeSupermint\Src\Models\SupermintFontList;

$list = new SupermintFontList();
$list->addFont('p');
$list->addFont('h1');
$list->addFont('h2');
$list->addFont('h3');
$list->addFont('h4');
$list->addFont('h5');
$list->addFont('alternate');
$list->addFont('small');

echo $list->getCssUrlFromList();
