/* global cyberPanel, sound */
var systemInfoWidget = {
	handle: function(data) {
		cyberPanel.systemInfo = data;
		if (
			cyberPanel.systemInfo.temperatures.limits.cpu < cyberPanel.systemInfo.temperatures.cpu
			|| cyberPanel.systemInfo.temperatures.limits.gpu < cyberPanel.systemInfo.temperatures.gpu
		) {
			sound.playAlert();
		}
	},
};