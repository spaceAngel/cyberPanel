socket = {

	conn: null,

	open: function() {
		this.conn = new WebSocket('ws://192.168.0.2:8080');
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
		console.log(JSON.parse(data.data));
	}

}
