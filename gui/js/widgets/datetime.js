var dateTimeWidget = {
	handle: function(data) {

		$('[data-prop="time"]').html(data.time);
		$('[data-prop="date"]').html(data.date);
	}
}