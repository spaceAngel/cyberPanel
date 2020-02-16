/* global Vue, socket, dateTimeWidget, keyboardWidget, systemInfoWidget, macrosWidget, defaultDataStruct, mediaWidget, mainPanelWidget, graph */
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
			setTimeout(function() {cyberPanel.loaded = true;}, 2500);
		}
	});

	socket.open();

	socket.registerHandler('datetime', dateTimeWidget.handle);
	socket.registerHandler('systeminfo', systemInfoWidget.handle);
	socket.registerHandler('keyboard', keyboardWidget.handle);
	socket.registerHandler('media',  mediaWidget.handle);

	setInterval(function() {
		socket.sendMultiple([
			{command:'datetime', parameters:[]},
			{command:'keyboard', parameters:[]},
			{command:'media', parameters:[]},
			{command:'systeminfo', parameters:[]},
		]);
	}, 1000);

	socket.registerHandler('loadmacros', macrosWidget.handle);
	setInterval( function() {socket.send('loadmacros', 123);},20000);

	mainPanelWidget.init('mainSwipingPanel');
	graph.init();
});