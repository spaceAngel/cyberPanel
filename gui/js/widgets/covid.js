/* global cyberPanel */
var covidWidget = {
	handle: function(data) {
		cyberPanel.covid.news = data.news;
	}
};