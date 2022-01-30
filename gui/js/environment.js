/* global NoSleep, stayAwakeModule */
var environment = {

	noSleep: stayAwakeModule.init(),
	wakeLock: null,

	noSleepEnable: function() {
		stayAwakeModule.setEnabled();
		return;
	},

	noSleepDisable: function() {
		stayAwakeModule.setDisabled();
		return;
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