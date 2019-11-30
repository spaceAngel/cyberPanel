IconBar = {
		
	activateIcons: function() {
		$(document).on('click', '.js-icon', function(e) {
			$(e.currentTarget).toggleClass('icon-off');
		});
		IconBar.activateFullscreenIcon();
		IconBar.activateNoSleepIcon();
	},

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

	activateNoSleepIcon: function() {
		$(document).on('click', '.js-nosleep', function(e) {
			if ($(e.currentTarget).data('nosleep') == 'on') {
				environment.noSleepDisable();
				$(e.currentTarget).data('nosleep', 'off');
			} else {
				environment.noSleepEnable();
				$(e.currentTarget).data('nosleep', 'on');
			}
		});
	}
}