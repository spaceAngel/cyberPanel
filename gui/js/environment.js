environment = {

	enableNoSleep : function() {
		try {
			var noSleep = new NoSleep();
			noSleep.enable();
		} catch (e) {
			console.log(456);
		}
	},
	
	enableFullScreen : function() {
		document.documentElement.requestFullscreen();
	}
	
	
}