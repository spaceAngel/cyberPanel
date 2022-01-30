/* global socket, cyberPanel, mixins, environment, sound */
mixins.push({
	methods: {
		keyPress: function(event) {
			socket.send('keypress', event.target.getAttribute('data-key'));
		}

	}
});
