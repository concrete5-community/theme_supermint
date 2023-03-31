<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if (!$content && is_object($c) && $c->isEditMode()) : ?>
	<div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Content Block.')?></div> 
<?php else :
	$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
	preg_match_all('/<h3[^>]*>(.*?)<\/h3>/si', $content, $matches);
	if ($matches[1][0] != "") {
		$heading_value = $matches[1][0];
		$content = str_replace($matches[0][0], '', $content);
	} else {
		$heading_value =  t('Click me');
	}

	/* 
	// -- this is a nicer way but become heavy when we try to extract something like <h3><i class="fa">Toto</i></h3>
	$doc = new DOMDocument();
	$doc->loadHTML($content);
	$headings = $doc->documentElement->getElementsByTagName('h3');
	$heading = $headings->item(0);
	if (isset($heading->nodeValue)) {
		$heading_value = $heading->ownerDocument->saveHTML($heading);
		$heading->parentNode->removeChild($heading);
	} else {
		$heading_value =  t('Click me');
	}
	*/

	?><a href="#content-popup-<?php echo $bID?>" class="<?php echo $o->popup_button_type . ' ' . $o->popup_button_color ?> mpf-inline open-popup-link"><?php echo $heading_value ?></a>
	<div id="content-popup-<?php echo $bID?>" class="white-popup mfp-hide"><?php print $content ?></div>
	<?php endif ?>
