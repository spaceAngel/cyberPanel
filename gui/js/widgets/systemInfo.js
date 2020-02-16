/* global cyberPanel, sound, graph */
var systemInfoWidget = {
	handle: function(data) {
		cyberPanel.systemInfo = data;
		if (
			cyberPanel.systemInfo.temperatures.limits.cpu < cyberPanel.systemInfo.temperatures.cpu
			|| cyberPanel.systemInfo.temperatures.limits.gpu < cyberPanel.systemInfo.temperatures.gpu
		) {
			sound.playAlert();
		}

		graph.updateCpuLoad(cyberPanel.systemInfo.cpuload);
		graph.updateCpuTemp(cyberPanel.systemInfo.temperatures.cpu);
		graph.updateGpuTemp(cyberPanel.systemInfo.temperatures.gpu);
		graph.refresh();
	},
};