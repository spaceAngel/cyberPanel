/* global socket, cyberPanel */
var lockScreenImage = {
	handle: function(data) {
		cyberPanel.lockScreen = data;
	},

	init: function() {
		socket.registerHandler('lockscreenimage', lockScreenImage.handle);
		setTimeout( function() {
			socket.send('lockscreenimage', 123);
		}, 1000);
		setInterval( function() { socket.send('lockscreenimage', 123);}, 60000);
	}
};
