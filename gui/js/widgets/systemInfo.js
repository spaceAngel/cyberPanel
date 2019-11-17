var systemInfoWidget = {
	handle: function(data) {
		console.log(data.temperatures);
		templates.display('.js-temperature', data.temperatures);
	}
}