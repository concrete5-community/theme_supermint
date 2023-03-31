ccmValidateBlockForm = function() {
	
	if ($('#field_1_textbox_text').val() == '') {
		ccm_addError('Missing required text: Name');
	}

	if ($('#field_6_image_fID-fm-value').val() == '' || $('#field_6_image_fID-fm-value').val() == 0) {
		ccm_addError('Missing required image: Portrait');
	}


	return false;
}
