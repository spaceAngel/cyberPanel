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

	swipeLeft: function() {
		cyberPanel.currentPanel++;
		if (cyberPanel.currentPanel > mainPanelWidget.getPanelsCount()) {
			cyberPanel.currentPanel = 1;
		}
	},

	swipeRight: function() {
		cyberPanel.currentPanel--;
		if (cyberPanel.currentPanel == 0) {
			cyberPanel.currentPanel = mainPanelWidget.getPanelsCount();
		}
	},

	getPanelsCount: function() {
		return mainPanelWidget.container.children.length;
	}
};