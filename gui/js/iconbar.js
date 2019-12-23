/* global cyberPanel, mixins, environment, sound */
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
		},

		toggleSound: function() {
			cyberPanel.sound = !cyberPanel.sound;
			if (cyberPanel.sound) {
				sound.playAlert();
			}
		}

	}
});
