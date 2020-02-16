/* global Chart */
var graph = {
	chart: null,
	data: {
		cpuload: [0,0,0,0,20,0,0,0,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		cputemp: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		gputemp: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		memory: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
	},

	init: function() {
		graph.chart = new Chart(document.getElementById('chart').getContext('2d'), {
			type: 'line',
			data: {
				labels: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',''],
				datasets: graph.getData()
			},
			options: {
				legend: {
					labels: {
						fontSize: 21
					},
				},
				scales: {
					yAxes: [{
						ticks: {
							suggestedMin: 0,
							suggestedMax: 100,
							fontSize: 19
						}
					}]
				}
			}
		});
	},

	updateCpuLoad: function(val) {
		graph.data.cpuload.push(val);
		if (graph.data.cpuload.length > 20) {
			graph.data.cpuload.shift();
		}
	},

	updateCpuTemp: function(val) {
		graph.data.cputemp.push(val);
		if (graph.data.cputemp.length > 20) {
			graph.data.cputemp.shift();
		}
	},

	updateGpuTemp: function(val) {
		graph.data.gputemp.push(val);
		if (graph.data.gputemp.length > 20) {
			graph.data.gputemp.shift();
		}
	},

	refresh: function() {
		graph.chart.data.datasets[0].data = graph.data.cpuload;
		graph.chart.data.datasets[1].data = graph.data.cputemp;
		graph.chart.data.datasets[2].data = graph.data.gputemp;
		graph.chart.update();
	},

	getData: function() {
		return [
			{label: 'cpuload', data: graph.data.cpuload, fill: false, backgroundColor: ['#330000'], borderColor: ['#660000'], borderWidth: 6},
			{label: 'cputemp', data: graph.data.cputemp, fill: false, backgroundColor: ['#003300'], borderColor: ['#006600'], borderWidth: 6},
			{label: 'gputemp', data: graph.data.gputemp, fill: false, backgroundColor: ['#000033'], borderColor: ['#000066'], borderWidth: 6}
		];
	}
};
