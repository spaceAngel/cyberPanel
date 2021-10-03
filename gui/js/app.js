/*
	global Vue, socket,
		networkWidget, dateTimeWidget, keyboardWidget, systemInfoWidget, hwInfoWidget, macrosWidget, defaultDataStruct, mediaWidget, mainPanelWidget, lockScreenImage, fileManager,
		upsStatus, speaker
*/
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
		},
		watch: {
			currentPanel(currentPanel) {
				localStorage.currentPanel = currentPanel;
			}
		}
	});

	socket.open();

	socket.registerHandler('datetime', dateTimeWidget.handle);
	socket.registerHandler('systeminfo', systemInfoWidget.handle);
	socket.registerHandler('hwinfo', hwInfoWidget.handle);
	socket.registerHandler('keyboard', keyboardWidget.handle);
	socket.registerHandler('media',  mediaWidget.handle);
	socket.registerHandler('downloads',  downloadsWidget.handle);
	socket.registerHandler('network',  networkWidget.handle);

	fileManager.init();
	setInterval(function() {
		socket.sendMultiple([
			{command:'datetime', parameters:[]},
			{command:'keyboard', parameters:[]},
			{command:'media', parameters:[]},
			{command:'systeminfo', parameters:[]},
			{command:'downloads', parameters:[]},
			{command:'network', parameters:[]},
		]);
	}, 900);

	setInterval(function() {
		socket.sendMultiple([
			{command:'hwinfo', parameters:[]},
		]);
	}, 30000);

	setTimeout( function() {socket.send('network', 123);}, 1000);
	setInterval( function() {socket.send('network', 123);}, 20 * 1000);

	setTimeout( function() {
		socket.sendMultiple([
			{command:'hwinfo', parameters:[]},
		]);
	}, 1000);

	socket.registerHandler('loadmacros', macrosWidget.handle);
	setInterval( function() {socket.send('loadmacros', 123);},20000);

	lockScreenImage.init();

	mainPanelWidget.init('mainSwipingPanel');
	lastFmTrackInfo.init();
	covidWidget.init();
	upsStatus.init();
	speaker.init();
});
