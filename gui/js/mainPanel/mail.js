/* global cyberPanel, socket */
var mail = {
	emails: [],
	folders: [],
	unread: 0,
	quota: 0,

	folder : 0,
	page: 0,

	paging: 50,

	rangeMin: 0,
	rangeMax: 0,
	rangeTotal: 0,

	errorOnConnect: false,

	init: function() {
		if (document.getElementById('mailClient')) {
			socket.registerHandler('mail.getmails',  mail.handle);
			setTimeout(function() {
				mail.loadEmails()
			}, 5000);
		}
	},

	loadEmails: function() {
		socket.send('mail.getmails', 123);
		setTimeout(
			function() {mail.loadEmails();},
			120000
		);
	},

	handle: function(data) {
		mail.errorOnConnect = data.errorOnConnect;
		if (!data.errorOnConnect)  {
			mail.folders = data.folders;
			mail.selectFolder(mail.folder);
			mail.unread = data.unread;
			mail.quota = data.quota;
		}
	},

	selectFolder: function(folder) {
		if (folder >= mail.folders.length) {
			return;
		}
		if (folder != mail.folder) {
			mail.page = 0;
		}
		mail.folder = folder;
		mail.emails = mail.folders[folder].emails;
		mail.calculateRange();
	},

	calculateRange: function() {
		mail.rangeMin = mail.page * mail.paging + 1;
		mail.rangeMax = (mail.page + 1) * mail.paging;
		mail.rangeTotal =  typeof mail.folder == 'number' ? mail.folders[mail.folder].emails.length : 0;
		mail.rangeMax = Math.min(mail.rangeMax, mail.rangeTotal);
	},

	prevPage: function() {
		if (mail.page > 0) {
			mail.page--;
		}
		mail.calculateRange();
	},

	nextPage: function() {
		if (mail.rangeMax < mail.rangeTotal) {
			mail.page++;
		}
		mail.calculateRange();
	}

};
