/* global cyberPanel, socket*/
var mediaWidget = {
	handle: function(data) {
		cyberPanel.media = data;
	},

	volumeUp: function() {
		socket.send('media', 'volumeup');
	},

	volumeDown: function() {
		socket.send('media', 'volumedown');
	},

	volumeMute: function() {
		socket.send('media', 'volumemute');
	},

	volumeUnmute: function() {
		socket.send('media', 'volumeunmute');
	}

};
