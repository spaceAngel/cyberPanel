/* global NoSleep */
var environment = {

	noSleep: stayAwakeModule.init(),
	wakeLock: null,

	noSleepEnable: function() {
	 stayAwakeModule.enable();return;

		navigator.getWakeLock("screen").then(function(wakeLock) {
			environment.wakeLock = wakeLock.createRequest();
 			return;
		});

		environment.noSleep.enable();
	},

	noSleepDisable: function() {
		stayAwakeModule.disable();return;
		if (environment.wakeLock !== null) {
			environment.wakeLock.cancel();
		} else {
			environment.noSleep.disable();
		}
	},

	fullscreenDisable: function() {
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		}
	},

	fullscreenEnable: function() {
		if (document.documentElement.requestFullscreen) {
			document.documentElement.requestFullscreen();
		} else if (document.mozRequestFullScreen) {
			document.mozRequestFullScreen();
		} else if (document.webkitRequestFullScreen) {
			document.webkitRequestFullScreen();
		} else if (document.msRequestFullscreen) {
			document.msRequestFullscreen();
		}
	}
};