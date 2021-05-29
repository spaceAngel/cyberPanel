/* global cyberPanel, sound, config */
var systemInfoWidget = {

	alert: false,

	handle: function(data) {
		cyberPanel.systemInfo = data;
		if (
			config.hwLimits.cpu.temperature < cyberPanel.systemInfo.temperatures.cpu
			|| config.hwLimits.gpu.temperature < cyberPanel.systemInfo.temperatures.gpu
			|| config.hwLimits.cpu.load < cyberPanel.systemInfo.cpu.load
			|| config.hwLimits.gpu.load < cyberPanel.systemInfo.gpu.load
			|| config.hwLimits.memory < cyberPanel.systemInfo.memory.used.bytes
		) {
			sound.playAlert();
			systemInfoWidget.alert = true;
		} else {
			systemInfoWidget.alert = false;
		}

		var fans = Object.values(cyberPanel.systemInfo.fans);
		for (var i = 0; i < fans.length; i++) {
			if (cyberPanel.fans.min[i] !== undefined) {
				cyberPanel.fans.min[i] = Math.min(fans[i], cyberPanel.fans.min[i]);
			} else {
				cyberPanel.fans.min[i] = fans[i];
			}
			if (cyberPanel.fans.max[i] !== undefined) {
				cyberPanel.fans.max[i] = Math.max(fans[i], cyberPanel.fans.max[i]);
			} else {
				cyberPanel.fans.max[i] = fans[i];
			}
		}
	},
};
