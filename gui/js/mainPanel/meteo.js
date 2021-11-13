/* global axios, config */

var meteo = {
	meteoData: null,

	init: function() {
		if (document.getElementById('meteo')) {
			meteo.updateData();
			setInterval(
				function() {
					meteo.updateData();
				}, 5 * 60000
			);
		}
	},

	updateData: async function() {
		axios({
			method: 'get',
			url: 'https://api.golemio.cz/v2/meteosensors/?limit=12&latlng=' + config.geolocation.latitude + '%2C' + config.geolocation.longitude,
			mode: 'no-cors',
			headers: {
				'Content-Type': 'application/json',
				'X-Access-Token': config.keys.golemio
			},
		}).then(async function (response) {
			var index = 0;
			if (
				response.data.features[index].properties.wind_speed == null
				|| response.data.features[index].properties.wind_direction == null
			) {
				index = 1;
			}
			meteo.meteoData = {
				temperature: {
					air: response.data.features[index].properties.air_temperature,
					road: response.data.features[index].properties.road_temperature
				},
				wind: {
					speed: response.data.features[index].properties.wind_speed,
					direction: response.data.features[index].properties.wind_direction,
				},
				humidity: response.data.features[index].properties.humidity,
				station: {
					name: response.data.features[index].properties.name,
					updated: response.data.features[index].properties.updated_at,
				}
			};
		});
	},

};
