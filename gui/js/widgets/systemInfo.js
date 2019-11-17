var systemInfoWidget = {
	handle: function(data) {
		templates.display('.js-temperature', data.temperatures);

		$('.js-storages').html('');
		for (var i = 0; i<data.storages.length; i++) {
			var template = $('.js-template-storage').clone();
			$(template).removeClass('js-template-storage').removeClass('template');
			templates.display(template, data.storages[i]);
			$(template).find('.js-bar').css(
				"width",
				data.storages[i].used  * 100 / data.storages[i].size + '%' 
			);

			$('.js-storages').append(template);
		}
		
	}
}