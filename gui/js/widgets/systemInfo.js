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

		$('.js-cpu-bar').css('width', data.cpuload + '0%');

		templates.display('.js-template-memory', data.memory);
		$('.js-memory-bar').css('width', data.memory.used  * 100/ data.memory.total + '%');

		systemInfoWidget.humanizeBytes();
		
	},


	humanizeBytes: function() {
		$('.js-bytes').each(function(index, elm) {
			size = $(elm).html();
			$(elm).html(systemInfoWidget.bytesToHuman(size))
		});
	},

	bytesToHuman: function(size) {
		var i = 0;
		var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
		do {
			size = size / 1024;
			i++;
		} while (size > 1024);

		return Math.max(size, 0.1).toFixed(1) + byteUnits[i];
	} 


}