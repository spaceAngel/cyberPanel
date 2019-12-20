IconBar = {
		
	activateFullscreenIcon: function() {
		$(document).on('click', '.js-fullscreen', function(e) {
			if ($(e.currentTarget).data('fullscreen') == 'on') {
				environment.fullscreenDisable();
				$(e.currentTarget).data('fullscreen', 'off');
			} else {			
				environment.fullscreenEnable();
				$(e.currentTarget).data('fullscreen', 'on');
			}
		});
	},
}

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
