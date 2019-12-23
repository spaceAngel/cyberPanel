var defaultDataStruct = {
	datetime: {
		date: '',
		time: '',
		holiday: ''
	},
	systemInfo: {
		cpuLoad: 40,
		memory: {
			used: 100,
			total: 1000
		},
		temperatures: {
			cpu: 100,
			gpu: 100,
			limits: {
				cpu: 30,
				gpu: 30
			}
		},
		storages: []
	},
	keyboard: {
		numlock: 'off',
		capslock: 'off',
		scrolllock:'off'
	},
	macros: [],
	noSleep: false,
	fullScreen: false,
	loaded: false,
	sound: false
};