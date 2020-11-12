/* global cyberPanel, sound, graph */
var systemInfoWidget = {
	handle: function(data) {
		cyberPanel.systemInfo = data;
		if (
			config.hwLimits.cpu.temperature < cyberPanel.systemInfo.temperatures.cpu
			|| config.hwLimits.gpu.temperature < cyberPanel.systemInfo.temperatures.gpu
		) {
			sound.playAlert();
		}

		graph.updateCpuLoad(cyberPanel.systemInfo.cpuload);
		graph.updateCpuTemp(cyberPanel.systemInfo.temperatures.cpu);
		graph.updateGpuTemp(cyberPanel.systemInfo.temperatures.gpu);
		graph.refresh();
	},
};