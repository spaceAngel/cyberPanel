$(document).ready(function() {
			
	environment.enableNoSleep();
	socket.open();

	intervalCommandRunner.registerRunner(1000, 'datetime', dateTimeWidget.handle);
	intervalCommandRunner.registerRunner(1000, 'systeminfo', systemInfoWidget.handle);

});