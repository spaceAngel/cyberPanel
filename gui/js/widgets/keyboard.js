/* global cyberPanel */
var keyboardWidget = {
	
	states: {
		numlock: 'off',
		capslock: 'off',
		scrolllock:'off'
	},

	handle: function(data) {
		keyboardWidget.states = data;
	}
};
