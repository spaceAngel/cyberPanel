var socket = {
	conn: null,

	handlers: {},

	open: function() {
		socket.conn = new WebSocket('ws://' + window.location.hostname + ':8081');
		socket.conn.onmessage = this.onMessage;
		socket.conn.addEventListener('error', function (event) {
			cyberPanel.disconnected = true;
			setTimeout(function() {
				if (cyberPanel.disconnected) {
					if (cyberPanel.noSleep) {
						cyberPanel.toggleNoSleep()
					}
					if (cyberPanel.fullScreen) {
						cyberPanel.toggleFullScreen();
					}
				}
			}, 60000);
		});
		socket.conn.onclose = function() {
			socket.handleDisconnect();
		}
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
		if (rawData.data == 'unauthorized') {
			location.href = 'unauthorized';
		}

		var data = (JSON.parse(rawData.data));
		if (socket.handlers[data.command] !== undefined) {
			cyberPanel.disconnected = false;
			socket.handlers[data.command](data.response);
		}
	},

	registerHandler: function(command, handler) {
		this.handlers[command] = handler;
	}

};
