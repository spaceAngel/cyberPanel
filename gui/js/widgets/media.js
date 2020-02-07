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
	},

	play: function() {
		socket.send('media', 'play');
	},

	stop: function() {
		socket.send('media', 'stop');
	},

	pause: function() {
		socket.send('media', 'pause');
	},

	next: function() {
		socket.send('media', 'next');
	},

	previous: function() {
		socket.send('media', 'previous');
	}

};


document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('mediaPanel').addEventListener('swiped-right', function(e) {
		mediaWidget.previous();
	});
	document.getElementById('mediaPanel').addEventListener('swiped-left', function(e) {
		mediaWidget.next();
	});
});
