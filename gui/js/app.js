$(document).ready(function() {
			
	environment.enableNoSleep();
	socket.open();

	intervalCommandRunner.registerRunner(1000, 'datetime', dateTimeWidget.handle);
	intervalCommandRunner.registerRunner(1000, 'systeminfo', systemInfoWidget.handle);

	socket.registerHandler('loadmacros', MacrosWidget.handle);
	setTimeout( function() {socket.send('loadmacros', 123)},1000);

});