/* global cyberPanel, sound, graph */
var downloadsWidget = {
	handle: function(data) {
		cyberPanel.downloads = data.downloads;
	},
};