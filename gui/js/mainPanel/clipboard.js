/* global socket  */

var clipboard = {
	history: [],

	init: function() {
		if (document.getElementById('clipboard')) {
			setInterval(
				function() {
					clipboard.updateData();
				}, 1000
			);
			socket.registerHandler('clipboard.history',  clipboard.handle);
		}
	},

	updateData: async function() {
		socket.send('clipboard.history', {});
	},

	handle: function(data) {
		clipboard.history = data[0];
	},

	setContent: function(clipboardContent) {
		socket.send(
			'clipboard.set',
			clipboardContent
		);
	}

};
