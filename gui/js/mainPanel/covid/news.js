/* global cyberPanel, socket */
var covidNewsWidget = {

	unread: 0,
	news: [],
	readNews: [],

	init: async function() {
		if (!document.getElementById('covidNews')) {
			return;
		}
		if (localStorage.covidNewsRead) {
			covidNewsWidget.readNews = localStorage.covidNewsRead.split('|');
		}
		socket.registerHandler('covid.news', covidNewsWidget.handle);
		setInterval( function() {socket.send('covid.news', 123);}, 5 * 60 * 1000);
		setTimeout( function() {socket.send('covid.news', 123);}, 8000);
		if (!localStorage.readNews) {
			localStorage.readNews  = [];
		}
		cyberPanel.$watch('covid.news', async function(newval) {
			covidNewsWidget.unread = 0;
			for (var i = 0; i< newval.length; i++) {
				var elm = document.createElement('div');
				elm.innerHTML = newval[i].md5;
				if (!covidNewsWidget.readNews.includes(elm.innerHTML)) {
					covidNewsWidget.unread++;
				}
			}
			if (
				document.querySelectorAll("[data-tabId='covidNews']")[0].className.includes('active')
			) {
				covidNewsWidget.markAllAsRead();
			}
		});

		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutationRecord) {
				if (mutationRecord.target.className.includes('active')) {
					covidNewsWidget.markAllAsRead();
				}
			});
		});

		var target = document.querySelectorAll("[data-tabId='covidNews']")[0];
		observer.observe(target, { attributes : true, attributeFilter : ['class'] });

		document.getElementById('covidNews').addEventListener('swiped-down', function(e) {
			if (document.getElementById('covidNews').scrollTop == 0) {
				socket.send('covid.news', 123);
			}
		});
	},

	markAllAsRead : function() {
		var news = document.querySelectorAll('.js-newContent');
		for (var i = 0; i < news.length; i++) {
			if (!covidNewsWidget.readNews.includes(news[i].innerHTML)) {
				covidNewsWidget.readNews.push(news[i].innerHTML);
			}
		}
		covidNewsWidget.unread = 0;
		localStorage.covidNewsRead = covidNewsWidget.readNews.join('|');
	},

	handle: function(data) {
		cyberPanel.covid.news = data.news;
		covidNewsWidget.news = data.news;
	},

};
