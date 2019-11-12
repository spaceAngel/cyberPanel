environment = {

	enableNoSleep : function() {
		var noSleep = new NoSleep();
		noSleep.enable();
	},
	
	enableFullScreen : function() {
		document.documentElement.requestFullscreen();
	}
	
	
}