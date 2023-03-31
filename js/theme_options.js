$(document).ready(function() {
	var paneLoaded = false;
	var cookies = Cookies.get();
	/*** Preset select ***/
	$('#preset_id').change(function() {
		$('#preset_to_edit').submit();
	});

	// -- Les panes -- //
	if (cookies.activeOptionPane) {
		var anchor = $("#" + cookies.activeOptionPane);
		if (anchor.length) {
			changePane(anchor);
			paneLoaded = true;
		}
	}
	// Si aucun pane à été chargé, on charge le premier
	if (!paneLoaded) {
		$('.mcl-options-body:first-child').show().addClass('active');
		$('.mcl-options-nav li:first-child').addClass('active');
	}
	$('.mcl-options-nav a').click(function (e){

		changePane($(this),e);
	})

	// -- Les Toggles -- \\

	$('.toggle').on('click', function(e){
		var t = $(this);
	  t.toggleClass("toggle-on");
		t.find('input[type=radio]').each(function(){
			//  if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
			// 	 $(this).prop("checked", !$(this).attr("checked"));
			//  } else {
			 		$(this).attr("checked", !$(this).attr("checked"));
				// }
		 });
	    // t.find('input[type=radio]').attr("checked", false);
	    // if (t.is('.toggle-on')) {
	    // 	t.find('.on').attr("checked", true);
	    // } else {
	    // 	t.find('.off').attr("checked", true);
	    // }
	    e.preventDefault();
	});


	// -- Les Sliders jQuery UI -- \\

	$('.ui-slider').each(function (i) {
		var t = $(this);
		var input = $("#" + t.data('rel'));
		t.slider({
			min: t.data('min'),
			max: t.data('max'),
			step: t.data('step'),
			value: input.val(),
			slide: function( event, ui ) {
				input.val( ui.value );
			}
		});
	})

	$('.tochosen').chosen();

	// --  Font management -- \\

	$('.font_selector').chosen({width: "95%"}).change(function(e,i) {

		var t = $(this);
		var id = t.attr('id');
		var val = t.val();

		if (!val) return;

		var container = t.parent().parent().parent().find('#' + id + '_details_wrapper');
		container.addClass('load');

		container.load(FONT_DETAILS_TOOLS_URL,{
			font:val,
			variantName : t.data('variant'),
			subsetName : t.data('subset'),
			variantType : t.data('variantype')
		},function(){
			$(this).removeClass('load');
			$(this).find('.variant_selector').chosen({width: "70%"});
			console.log($(this).find('.variant_selector'));
		});

	});

	// Fonts variants & Selected

	$('.variant_selector').chosen({width: "70%"}).change(function(e,i){
		// Ici on va donner le choix à l'utilisateur de selectionner la graisse qu'il veut en temps que principale
		var t = $(this);
		var values = t.val();
		if (!values || values.length < 2) return;
		var selected = $("#" + t.attr('id') + '_selected');
		var html = '';
		for (var i = 0, len = values.length; i < len; ++i) {
		    html += '<option value="' + values[i] + '">' + values[i] + '</option>';
		}
		selected.html(html).parent().show();
	});

	// OK, c'est chargé

	$('.mcl-options-wrapper').addClass('active');
});

$(function(){
	$('.mcl-options-wrapper').addClass('active');
})

function changePane (t,e) {
		if (e) e.preventDefault();
		// Le panneaux visibles a cacher
		$('.mcl-options-body.active').hide();
		// On desactive tous les element de menus
		$('.mcl-options-nav li.active').removeClass('active');

		// var t = $(this);
		// On active le 'li' parent
		t.parent().addClass('active');
		var rel = t.attr('href');
		Cookies.set('activeOptionPane', t.attr('id'));
		var rel = $(rel);
		rel.fadeIn().addClass('active');
}
