/* global Vue, socket, dateTimeWidget, keyboardWidget, systemInfoWidget, hwInfoWidget, macrosWidget, defaultDataStruct, mediaWidget, mainPanelWidget, graph, lockScreenImage */
var cyberPanel;
var mixins = [];

document.addEventListener('DOMContentLoaded', function() {

	cyberPanel = new Vue({
		el: '#cyberPanel',
		mixins: mixins,
		data: defaultDataStruct,
		delimiters: ['<%', '%>'],
		mounted: function() {
			setTimeout(function() {cyberPanel.loaded = true;}, 2500);
		}
	});

	socket.open();

	socket.registerHandler('datetime', dateTimeWidget.handle);
	socket.registerHandler('systeminfo', systemInfoWidget.handle);
	socket.registerHandler('hwinfo', hwInfoWidget.handle);
	socket.registerHandler('keyboard', keyboardWidget.handle);
	socket.registerHandler('media',  mediaWidget.handle);
	socket.registerHandler('downloads',  downloadsWidget.handle);
	
	setInterval(function() {
		socket.sendMultiple([
			{command:'datetime', parameters:[]},
			{command:'keyboard', parameters:[]},
			{command:'media', parameters:[]},
			{command:'systeminfo', parameters:[]},
			{command:'downloads', parameters:[]},
		]);
	}, 1000);

	setInterval(function() {
		socket.sendMultiple([
			{command:'hwinfo', parameters:[]},
		]);
	}, 30000);

	setTimeout( function() {
		socket.sendMultiple([
			{command:'hwinfo', parameters:[]},
		]);
	}, 1000);

	socket.registerHandler('loadmacros', macrosWidget.handle);
	setInterval( function() {socket.send('loadmacros', 123);},20000);

	socket.registerHandler('covid', covidWidget.handle);
	setInterval( function() {socket.send('covid', 123);}, 5 * 60 * 1000);
	setTimeout( function() {socket.send('covid', 123);}, 2000);
	setTimeout( function() {socket.send('covid', 123);}, 8000);
	
	lockScreenImage.init();

	mainPanelWidget.init('mainSwipingPanel');
	graph.init();
	lastFmTrackInfo.init();
});