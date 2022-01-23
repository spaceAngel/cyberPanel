/* global cyberPanel, mixins, socket */
var macrosWidget = {
	enableStates: [],

	handle: function(data) {
		cyberPanel.macros = data.macros;
	},

	init: function() {
		socket.registerHandler('macros.enabled', macrosWidget.handleEnabled);
		setInterval(
			function() {socket.send('macros.enabled', 123);},
			1500
		);
	},

	handleEnabled: function(data) {
		macrosWidget.enableStates = data.enabled;
	}
};

mixins.push({
	methods: {
		runMacro: function(hash) {
			if (
				macrosWidget.enableStates == null
				|| macrosWidget.enableStates[hash] == true
			) {
				socket.send('macro', [hash]);
			}
		}
	}
});
