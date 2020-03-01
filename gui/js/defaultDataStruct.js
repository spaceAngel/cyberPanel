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
		storages: [],
		processes: [],
		locked: true
	},
	keyboard: {
		numlock: 'off',
		capslock: 'off',
		scrolllock:'off'
	},
	media: {
		volume: 50,
		muted: false,
		currentsong: '',
		length: 50,
		position: 20,
		playing: false
	},
	lockScreen: {
		binary: null,
		type: null
	},
	macros: [],
	noSleep: false,
	fullScreen: false,
	loaded: false,
	sound: false,
	currentPanel: 3
};