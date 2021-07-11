/* global cyberPanel, socket */
var upsStatus = {
	data: {},

	init: function() {
		if (document.getElementById('upsStatus')) {
			socket.registerHandler('upsstatus',  upsStatus.handle);
			setInterval(function() {
				socket.send('upsstatus', 123)
			}, 1000);
		}
	},

	handle: function(data) {
		upsStatus.data = data;
	}
}
