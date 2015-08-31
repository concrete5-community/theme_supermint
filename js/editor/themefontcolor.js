if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
	RedactorPlugins.themefontcolor = function()
	{
		return {
			init: function()
			{
            var button = this.button.add('themefontcolor', 'Theme Font color');
            this.button.setAwesome('themefontcolor', 'fa-eyedropper');
            var $dropdown = this.button.addDropdown(button);
			$dropdown.width(180);
			this.themefontcolor.buildPicker($dropdown);
			},

			buildPicker: function($dropdown)
			{
	            var plugin = this.themefontcolor;
	            var self = this;

	            $.ajax({
	                'type': 'get',
	                'dataType': 'json',
	                'url': CCM_DISPATCHER_FILENAME + '/ThemeSupermint/tools/get_preset_colors',
	                'data': {
	                    'ccm_token': CCM_EDITOR_SECURITY_TOKEN,
	                    'cID': CCM_CID
	                },

	                success: function(response) {
						var func = function(e) {
							e.preventDefault();
							plugin.set($(this).attr('rel'));
						};


						$.each(response, function( name, value ) {
							$title = $('<li><span>' + name + '</span></li>');
							$dropdown.append($title);

							$.each(value,function(variable,color) {
								var $swatch = $('<li><a rel="text-' + variable + '-color" href="#" class="themefontcolor-color"><span></span>' + variable + '</a></li>');
								$swatch.find('span').css('background-color', color);
								$swatch.find('a').on('click', func);
								$dropdown.append($swatch);
							});
						});

					}
				});
			},
			set: function(c)
			{
				this.buffer.set();
				this.block.setAttr('class', c);				
			}

		};
	};
})(jQuery);