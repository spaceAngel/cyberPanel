intervalCommandRunner = {
	registerRunner : function(interval, command, handler) {
		socket.registerHandler(command, handler);
		setInterval(function() {socket.send(command, 547);}, interval);
	}
}