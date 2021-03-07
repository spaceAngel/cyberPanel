/* global cyberPanel, socket */
var fileManager = {
	files: [],
	path: null,

	init: function() {
		socket.registerHandler('files',  fileManager.handle);
		document.getElementById('fileManager').addEventListener('swiped-right', function(e) {
			fileManager.open('..');
			e.stopPropagation();
		});
		setInterval(function() {
			fileManager.refresh();
		}, 3000);
	},

	handle: function(data) {
		fileManager.files = data.files;
		fileManager.path = data.path;
	},

	refresh: function() {
		socket.send('files', fileManager.path);
	},

	open: function(currentPath) {
		socket.send('files', fileManager.path + '/' + currentPath);
	}

};
