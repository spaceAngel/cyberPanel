/* global cyberPanel, sound, config, hwInfoWidget */
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
			|| hwInfoWidget.isStorageOverLimit()
		) {
			sound.playAlert();
			systemInfoWidget.alert = true;
		} else {
			systemInfoWidget.alert = false;
		}
	},
};
