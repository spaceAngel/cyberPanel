/* global cyberPanel, socket */
var covidWidget = {

	readNews: [],
	unread: 0,

	init: async function() {
		cyberPanel.$watch('covid.news', async function(newval) {
			covidWidget.unread = 0;
			for (var i = 0; i< newval.length; i++) { 
				var elm = document.createElement('div');
				elm.innerHTML = newval[i].html;
				if (!covidWidget.readNews.includes(elm.innerHTML)) {
					covidWidget.unread++;
				}
			}
			if (
				document.querySelectorAll("[data-tabId='covidNews']")[0].className.includes('active')
			) {
				covidWidget.markAllAsRead();
			}
		});

		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutationRecord) {
				if (mutationRecord.target.className.includes('active')) {
					covidWidget.markAllAsRead();
				}
			});
		});

		var target = document.querySelectorAll("[data-tabId='covidNews']")[0];
		observer.observe(target, { attributes : true, attributeFilter : ['class'] });

		document.getElementById('covid').addEventListener('swiped-down', function(e) {
			if (document.getElementById('covidNews').scrollTop == 0) {
				socket.send('covid', 123);
			}
		});
	},

	markAllAsRead : function() {
		var news = document.querySelectorAll('.js-newContent');
		for (var i = 0; i < news.length; i++) {
			if (!covidWidget.readNews.includes(news[i].innerHTML)) {
				covidWidget.readNews.push(news[i].innerHTML);
			}
		}
		covidWidget.unread = 0;
	},
	
	handle: function(data) {
		cyberPanel.covid = data;
	},

};
