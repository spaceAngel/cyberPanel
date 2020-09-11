var lastFmTrackInfo = {
	init: async function() {
		cyberPanel.$watch('media.currentsong.name', async function(newval) {
			 axios({
				method: 'get',
				url: lastFmTrackInfo.buildUrl('track.getInfo', {autocorrect:1, artist: cyberPanel.media.currentsong.artist, track: cyberPanel.media.currentsong.title}),
				mode: 'no-cors',
				headers: {
					'Access-Control-Allow-Origin': '*',
					'Content-Type': 'application/json',
				},
			}).then(async function (response) {
				cyberPanel.lastfmTrackInfo = response.data.track;
				if (cyberPanel.lastfmTrackInfo.album == undefined) {
					cyberPanel.lastfmTrackInfo.album = { title: cyberPanel.media.currentsong.album};
				}
			});
		});
	},
	
	buildUrl: function(action, params) {
		params.method = action;
		params.api_key = config.lastfmApiKey; 
		var query = new URLSearchParams(params).toString();
		var url = 'http://ws.audioscrobbler.com/2.0/?format=json&' + query;
		return url;
	}
	
	
}


