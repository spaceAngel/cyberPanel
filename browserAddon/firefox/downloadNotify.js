/* global browser */
var downloadNotify = {

	interval: null,
	socket: null,

	init: function() {
		downloadNotify.socket = new WebSocket('ws://127.0.0.1:8081');
		downloadNotify.socket.onmessage = function(e) {}
		downloadNotify.socket.onclose = this.handleDisconnect;
	},

	startNotifying: function() {
		downloadNotify.interval = setInterval(function(e){
			var sendInfo = new Array();
			browser.downloads.search({}).then(function(search) {
				for (var download of search) {
					if (download.state == 'in_progress') {
						sendInfo.push({
							id: download.id,
							filename: download.filename,
							bytesReceived: download.bytesReceived,
							bytesTotal: download.totalBytes,
							estimatedEndTime: download.estimatedEndTime
						});
					}
				}

				downloadNotify.send(sendInfo);

				if (sendInfo.length == 0) {
					downloadNotify.stopNotyfing();
				}
			});
		}, 2000);
	},

	send: async function(sendInfo) {
		downloadNotify.socket.send(
			JSON.stringify({
				command: 'storeDownloads',
				parameters: sendInfo
			})
		);
	},

	stopNotyfing: function() {
		if (downloadNotify.interval !== null) {
			clearInterval(downloadNotify.interval);
		}
	},

	handleDisconnect: function() {
		setTimeout(function() {
			downloadNotify.init();
		}, 1200);
	},
}
setTimeout(function() {
	downloadNotify.init();
	browser.downloads.onCreated.addListener(function(){
		downloadNotify.startNotifying();
	});
	browser.downloads.onChanged.addListener(function(){
		downloadNotify.startNotifying();
	});
}, 2000);
