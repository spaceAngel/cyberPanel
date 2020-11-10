/* global cyberPanel, sound, graph */
var pingWidget = {
	pings: '', 
	time:0,
	disconnected:false,
	
	handle: function(data) {
		pingWidget.pings = data.pings.replaceAll('\n', "<br/>");
		pingWidget.disconnected = data.disconnected;
		pingWidget.time = data.time;
	}
};
