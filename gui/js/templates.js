var templates = {
	display: function(target, data) {
		$('[data-templatePlaceholder]', $(target)).each(function(index, elm) {
			attrName = $(elm).attr('data-templatePlaceholder');
			$(elm).html(data[attrName]);
		})
	}
}