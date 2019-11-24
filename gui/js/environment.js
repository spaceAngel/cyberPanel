environment = {

	enableNoSleep : function() {
		try {
			var noSleep = new NoSleep();
			noSleep.enable();
		} catch (e) {
		}
	},
	
	enableFullScreen : function() {
		$(document).on('click', '.js-fullscreen', function(e) {
			if ($(e.currentTarget).data('fullscreen') == 'on') {
				if (document.exitFullscreen) {
					 document.exitFullscreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
				$(e.currentTarget).data('fullscreen', 'off');
			} else {			
				if (document.documentElement.requestFullscreen) {
					document.documentElement.requestFullscreen();
				} else if (document.mozRequestFullScreen) {
					document.mozRequestFullScreen();
				} else if (document.webkitRequestFullScreen) {
					document.webkitRequestFullScreen();
				} else if (document.msRequestFullscreen) {
					document.msRequestFullscreen();
				}
				$(e.currentTarget).data('fullscreen', 'on');
			}
			$(e.currentTarget).toggleClass('icon-off');
		});
		
	}
	
	
}