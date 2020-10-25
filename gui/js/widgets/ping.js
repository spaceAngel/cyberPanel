/* global cyberPanel, sound, graph */
var pingWidget = {
	handle: function(data) {
		cyberPanel.ping = data[0].replaceAll('\n', "<br/>");
	}
};