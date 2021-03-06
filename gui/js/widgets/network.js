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

	handle: function(data) {
		if (data.ip != null) {
			networkWidget.ip = data.ip;
		} else {
			networkWidget.pings = data.pings.replaceAll('\n', '<br/>');
			networkWidget.disconnected = data.disconnected;
			networkWidget.time = data.time;
		}
	}
};
