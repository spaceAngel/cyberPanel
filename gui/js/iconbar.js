/* global cyberPanel, mixins, environment */
mixins.push({
	methods: {
		toggleNoSleep: function() {
			cyberPanel.noSleep = !cyberPanel.noSleep;
			if (cyberPanel.noSleep) {
				environment.noSleepEnable();
			} else {
				environment.noSleepDisable();
			}
		},
		
		toggleFullScreen: function() {
			cyberPanel.fullScreen = !cyberPanel.fullScreen;
			if (cyberPanel.fullScreen) {
				environment.fullscreenEnable();
			} else {
				environment.fullscreenDisable();
			}
		}
	}
});
