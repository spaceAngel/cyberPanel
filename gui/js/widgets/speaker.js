/* global socket */
var speaker = {

	enabled: false,

	handle: function(data) {
		speaker.enabled = data.enabled;
	},

	enable: function(state) {
		socket.send('speakerEnable', state);
	},

	init: function() {
		socket.registerHandler('speakerEnable', speaker.handle);
		setTimeout( function() {socket.send('speakerEnable', null);}, 200);
	}

};
