/* global cyberPanel, socket */
var icuMonitor = {
	data: null,
	interval: null,
	intervalRefreshRate: null,

	init: function() {
		if (document.getElementById('icuMonitor')) {
			socket.registerHandler('icumonitor.values.get',  icuMonitor.handle);
			setTimeout(function() {
				socket.send('icumonitor.values.get', 123)
			}, 500);
		}
	},

	handle: function(data) {
		icuMonitor.data = data;
		if (data.refreshRate + 10 != icuMonitor.intervalRefreshRate) {
			clearInterval(icuMonitor.interval);
			icuMonitor.intervalRefreshRate = data.refreshRate + 10
			icuMonitor.interval = setInterval(
				function() {
					socket.send('icumonitor.values.get', 123)
				},
				icuMonitor.intervalRefreshRate
			);
		}
	}
}
