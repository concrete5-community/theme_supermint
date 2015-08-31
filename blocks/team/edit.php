<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$ps = Loader::helper('form/page_selector');
?>

<div class="ccm-block-field-group">
	<h2>Name</h2>
	<?php  echo $form->text('field_1_textbox_text', $field_1_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Role</h2>
	<?php  echo $form->text('field_2_textbox_text', $field_2_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Facebook Url</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Linkedin Url</h2>
	<?php  echo $form->text('field_4_textbox_text', $field_4_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Twitter Url</h2>
	<?php  echo $form->text('field_5_textbox_text', $field_5_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Portrait</h2>
	<?php  echo $al->image('field_6_image_fID', 'field_6_image_fID', 'Choose Image', $field_6_image); ?>

	<table border="0" cellspacing="3" cellpadding="0" style="width: 95%;">
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_6_image_externalLinkURL">Link to URL:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_6_image_externalLinkURL', $field_6_image_externalLinkURL, array('style' => 'width: 100%;')); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_6_image_altText">Alt Text:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_6_image_altText', $field_6_image_altText, array('style' => 'width: 100%;')); ?></td>
		</tr>
	</table>
</div>
<!-- Le seecteur de page ne veut pas chosiir de page
<div class="ccm-block-field-group">
	<h2>Link to page</h2>
	
	<?php  //echo $ps->selectPage('field_7_link_cID', $field_7_link_cID, false); ?>
	<table border="0" cellspacing="3" cellpadding="0" style="width: 95%;">
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_7_link_text">Link Text:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_7_link_text', $field_7_link_text, array('style' => 'width: 100%;')); ?></td>
		</tr>
	</table>
</div>
-->
<div class="ccm-block-field-group" id="ccm-editor-pane">
	<h2>Main</h2>
	<?php  $this->inc('editor_init.php'); ?>
	<textarea id="field_8_wysiwyg_content" name="field_8_wysiwyg_content" class="advancedEditor ccm-advanced-editor"><?php  echo $field_8_wysiwyg_content; ?></textarea>
</div>


