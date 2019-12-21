/* global cyberPanel, mixins, socket */
var macrosWidget = {
	handle: function(data) {
		cyberPanel.macros = data.macros;
	}
};

mixins.push({
	methods: {
		runMacro: function(hash) {
			socket.send('macro', [hash]);
		}
	}
});
