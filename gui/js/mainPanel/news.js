/* global cyberPanel, socket */
var newsWidget = {

	unread: 0,
	news: [],
	readNews: [],

	init: async function() {
		if (!document.getElementById('news')) {
			return;
		}
		if (localStorage.newsRead) {
			newsWidget.readNews = localStorage.newsRead.split('|');
		}
		socket.registerHandler('news', newsWidget.handle);
		setInterval( function() {socket.send('news', 123);}, 5 * 60 * 1000);
		setTimeout( function() {socket.send('news', 123);}, 1000);
		if (!localStorage.readNews) {
			localStorage.readNews  = [];
		}
		cyberPanel.$watch('news', async function(newval) {
			newsWidget.unread = 0;
			for (var i = 0; i< newval.length; i++) {
				var elm = document.createElement('div');
				elm.innerHTML = newval[i].md5;
				if (!newsWidget.readNews.includes(elm.innerHTML)) {
					newsWidget.unread++;
				}
			}
			if (
				document.querySelectorAll("[data-tabId='news']")[0].className.includes('active')
			) {
				newsWidget.markAllAsRead();
			}
		});

		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutationRecord) {
				if (mutationRecord.target.className.includes('active')) {
					newsWidget.markAllAsRead();
				}
			});
		});

		var target = document.querySelectorAll("[data-tabId='news']")[0];
		observer.observe(target, { attributes : true, attributeFilter : ['class'] });

		document.getElementById('news').addEventListener('swiped-down', function(e) {
			if (document.getElementById('news').scrollTop == 0) {
				socket.send('news', 123);
			}
		});
	},

	markAllAsRead : function() {
		var news = document.querySelectorAll('.js-newContent');
		for (var i = 0; i < news.length; i++) {
			if (!newsWidget.readNews.includes(news[i].innerHTML)) {
				newsWidget.readNews.push(news[i].innerHTML);
			}
		}
		newsWidget.unread = 0;
		localStorage.newsRead = newsWidget.readNews.join('|');
	},

	handle: function(data) {
		cyberPanel.news = data.news;
		newsWidget.news = data.news;
	},

};
