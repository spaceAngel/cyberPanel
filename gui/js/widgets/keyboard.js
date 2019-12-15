var keyboardWidget = {
	handle: function(data) {
		for (led in data) {
			$('[data-led="' + led + '"]').attr('data-state', data[led]);
		}
	}
}