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
		processes: [],
		locked: true,
		gpu: {
			load: '0%',
			memory: {
				free: '10%',
				total: '2%'
			}
		}
	},
	hwInfo: {
		storages: [],
		gpu: '',
		cpu: '',
		kernel: '',
		distro: '',
		uptime: ''
	},
	keyboard: {
		numlock: 'off',
		capslock: 'off',
		scrolllock:'off'
	},
	media: {
		volume: 50,
		muted: false,
		currentsong: {
			name: '',
			title:'',
			artist: ''	
		},
		length: 50,
		position: 20,
		playing: false
	},
	lastfmTrackInfo: {
	},
	lockScreen: {
		binary: null,
		type: null
	},
	downloads:[],
	macros: [],
	covid: {
		news: [],
		stats: {
			cases: {
				today: 0,
				yesterday: 0,
				total: 0
			},
			tests: 0,
			hospitalised: 0,
			deaths: 0,
		},
		hospitalCapacities: []
	},
	noSleep: false,
	fullScreen: false,
	loaded: false,
	sound: false,
	ping: new Array(),
	currentPanel: 7
};