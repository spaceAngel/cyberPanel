$(document).ready(function() {

	socket.open();
	intervalCommandRunner.registerRunner(1000, 'datetime', dateTimeWidget.handle);
	intervalCommandRunner.registerRunner(1000, 'systeminfo', systemInfoWidget.handle);
	intervalCommandRunner.registerRunner(400, 'keyboard', keyboardWidget.handle);

	socket.registerHandler('loadmacros', MacrosWidget.handle);
	MacrosWidget.activateMacroIcons()
	setTimeout( function() {socket.send('loadmacros', 123)},1000);
	IconBar.activateIcons();
	
	$('.js-nosleep').click();
});