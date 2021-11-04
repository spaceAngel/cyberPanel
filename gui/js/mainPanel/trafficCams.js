/* global axios, config */

var trafficCams = {
	cams: [],

	init: function() {
		if (document.getElementById('trafficCams')) {
			trafficCams.updateData();
			setInterval(
				function() {
					trafficCams.updateData();
				}, 121000
			);
		}
	},

	updateData: async function() {
		axios({
			method: 'get',
			url: 'https://api.golemio.cz/v2/trafficcameras?limit=12&latlng=' + config.geolocation.latitude + '%2C' + config.geolocation.longitude,
			mode: 'no-cors',
			headers: {
				'Content-Type': 'application/json',
				'X-Access-Token': config.keys.golemio
			},
		}).then(async function (response) {
			trafficCams.cams = response.data.features;
		});
	}

};
