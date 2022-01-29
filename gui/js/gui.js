var gui = {
	bounce: function (id) {
		var element = document.getElementById(id);
		if (element) {
			element.classList.add('effect-bounce');
			setTimeout(
				function() {element.classList.remove('effect-bounce');},
				800
			);
		}
	}
};
