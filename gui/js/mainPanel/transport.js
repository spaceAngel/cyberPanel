/* global axios, config */

var transport = {
	departures: [],

	stops: new Map(),

	init: function() {
		if (document.getElementById('transport')) {
			transport.updateData();
			setInterval(
				function() {
					transport.updateData();
				}, 60000
			);
		}
	},

	updateData: async function() {
		axios({
			method: 'get',
			url: 'https://api.golemio.cz/v2/pid/departureboards/?' + config.publicTransportDepartures,
			mode: 'no-cors',
			headers: {
				'Content-Type': 'application/json',
				'X-Access-Token': config.keys.golemio
			},
		}).then(async function (response) {
			for (var i = 0; i < response.data.stops.length; i++) {
				transport.stops.set(
					response.data.stops[i].stop_id,
					response.data.stops[i].stop_name,
				);
			}
			transport.departures = response.data.departures;
		});
	},

	timeDiff: function timeDifference(datestring) {
		var date1 = Date.parse(datestring);
		var difference = date1 - Date.now();
		return transport.timeToString(difference);
	},

	timeToString: function(timeval) {

		var daysDifference = Math.floor(timeval/1000/60/60/24);
		timeval -= daysDifference*1000*60*60*24;

		var hoursDifference = Math.floor(timeval/1000/60/60);
		timeval -= hoursDifference*1000*60*60;

		var minutesDifference = Math.floor(timeval/1000/60);
		timeval -= minutesDifference*1000*60;

		var secondsDifference = Math.floor(timeval/1000);
		if (secondsDifference < 10) {
			secondsDifference = '0' + secondsDifference;
		}

		return minutesDifference + ':' + secondsDifference;

	}
};
