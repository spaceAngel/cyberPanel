/* global cyberPanel, sound */
var downloadsWidget = {
	handle: function(data) {
		cyberPanel.downloads = data.downloads;
	},
};