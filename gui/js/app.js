$(document).ready(function() {
			
	environment.enableNoSleep();
	//environment.enableFullScreen();

	socket.open();

	$(document).on('click ', 'input', function(e) {
		socket.send('datetime', 547);
	})

});