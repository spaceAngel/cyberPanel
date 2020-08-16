/* global Vue */
Vue.filter('bytesToHuman', function (value) {
	var i = 0;
	var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
	do {
		value = value / 1024;
		i++;
	} while (value > 1024);
	
	if  (value < 1) {
		value *= 1024;
		i--;
	}
	return Math.max(value, 0.1).toFixed(1) + byteUnits[i];
});

Vue.filter('milisecondsToHuman', function (value) {
	var minutes = Math.floor(value / 60000);
	var seconds = ((value % 60000) / 1000).toFixed(0);
	var hours = 0;
	if (minutes > 60) {
		hours = Math.floor(minutes / 60)
		minutes = minutes % 60;
	}
	var rslt = '';
	if (hours > 0) {
		rslt += minutes + ':';
	}
	rslt += minutes + ':';
	rslt += (seconds < 10 ? '0' : '') + seconds;
	return rslt;
});

Vue.filter('filename', function (value) {
	value = value.split('/');
	return value[value.length - 1];
})
