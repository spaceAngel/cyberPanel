/* global Vue, socket, dateTimeWidget, keyboardWidget, systemInfoWidget, intervalCommandRunner, macrosWidget, defaultDataStruct */
var cyberPanel;
var mixins = [];

document.addEventListener('DOMContentLoaded', function() {

	cyberPanel = new Vue({
		el: '#cyberPanel',
		mixins: mixins,
		data: defaultDataStruct,
		delimiters: ['<%', '%>'],
		mounted: function() {
			setTimeout(function() {cyberPanel.toggleNoSleep();}, 200);
		}
	});

	
	socket.open();
	intervalCommandRunner.registerRunner(1000, 'datetime', dateTimeWidget.handle);
	intervalCommandRunner.registerRunner(1000, 'systeminfo', systemInfoWidget.handle);
	intervalCommandRunner.registerRunner(400, 'keyboard', keyboardWidget.handle);

	socket.registerHandler('loadmacros', macrosWidget.handle);
	setTimeout( function() {socket.send('loadmacros', 123);},1000);
});