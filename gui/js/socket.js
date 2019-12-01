socket = {

	conn: null,

	handlers: {},

	open: function() {
		this.conn = new WebSocket('ws://' + window.location.hostname + ':8081');
		this.conn.onmessage = this.onMessage;
	},

	send: function(command, parameters) {
		if (!Array.isArray(parameters)) {
			parameters = Array(parameters);
		}

		this.conn.send(
			JSON.stringify({
				command: command,
				parameters: parameters
			})
		);
	},

	onMessage: function(data) {
		var data = (JSON.parse(data.data));
		if (socket.handlers[data.command] !== undefined) {
			socket.handlers[data.command](data.response);
		}
	},

	registerHandler: function(command, handler) {
		this.handlers[command] = handler;
	}

}
