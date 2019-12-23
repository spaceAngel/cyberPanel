/* global cyberPanel */
var sound = {
	alert: new Audio(),

	init: function() {
		sound.alert.src = 'sounds/alert.mp3';
	},

	playAlert: function() {
		if (cyberPanel.sound) {
			sound.alert.play();
		}
	}
};

sound.init();