var socket = {
	conn: null,

	handlers: {},

	open: function() {
		socket.conn = new WebSocket('ws://' + window.location.hostname + ':8081');
		socket.conn.onmessage = this.onMessage;
		socket.conn.onclose = this.handleDisconnect;
		socket.conn.sendmessage = async function(msg) {
			this.send(msg);
		};
	},

	send: async function(command, parameters) {
		if (!Array.isArray(parameters)) {
			parameters = Array(parameters);
		}

		socket.conn.send(
			JSON.stringify({
				command: command,
				parameters: parameters
			})
		);
	},

	sendMultiple: async function(commands) {
		socket.conn.send(
			JSON.stringify(commands)
		);
	},

	handleDisconnect: function() {
		setTimeout(function() {
			socket.open();
		}, 700);
	},

	onMessage: function(rawData) {
		var data = (JSON.parse(rawData.data));
		if (socket.handlers[data.command] !== undefined) {
			socket.handlers[data.command](data.response);
		}
	},

	registerHandler: function(command, handler) {
		this.handlers[command] = handler;
	}

};
