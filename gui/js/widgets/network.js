/* global cyberPanel, sound */
var networkWidget = {
	pings: '',
	time:0,
	disconnected:false,
	ip: {
		local: '',
		mac: '',
		public: '',
		gateway: '',
		dns: ''
	},
	traffic: {
		download: 0,
		upload: 0
	},

	handle: function(data) {
		networkWidget.ip = data.ip;
		networkWidget.pings = data.pings.replaceAll('\n', '<br/>');
		networkWidget.disconnected = data.disconnected;
		networkWidget.time = data.time;
		networkWidget.traffic = {
			download: data.traffic.download,
			upload: data.traffic.upload
		};
	}
};
