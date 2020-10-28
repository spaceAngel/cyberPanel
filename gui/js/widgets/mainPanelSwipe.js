/* global cyberPanel */
var mainPanelWidget = {
	container: null,
	init: function(id) {
		mainPanelWidget.container = document.getElementById(id);
		mainPanelWidget.container.addEventListener('swiped-right', function(e) {
			mainPanelWidget.swipeLeft();
		});
		mainPanelWidget.container.addEventListener('swiped-left', function(e) {
			mainPanelWidget.swipeRight();
		});
	},

	swipeRight: function() {
		cyberPanel.currentPanel++;
		if (cyberPanel.currentPanel == mainPanelWidget.getPanelsCount()) {
			cyberPanel.currentPanel = 0;
		}
	},

	swipeLeft: function() {
		cyberPanel.currentPanel--;
		if (cyberPanel.currentPanel < 0) {
			cyberPanel.currentPanel = mainPanelWidget.getPanelsCount() - 1;
		}
	},

	getPanelsCount: function() {
		return mainPanelWidget.container.children.length;
	}
};