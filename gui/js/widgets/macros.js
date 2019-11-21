var MacrosWidget = {
	handle: function(data) {
		$('.js-macros').html('');
		for (var i = 0; i<data.macros.length; i++) {
			var template = $('.js-template-macro').clone();
			$(template).removeClass('js-template-macro').removeClass('template');
			templates.display(template, data.macros[i]);
			$(template).find('i').addClass(data.macros[i].icon);
			$('.js-macros').append(template);


		}

	}
}