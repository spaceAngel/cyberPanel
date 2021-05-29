var defaultDataStruct = {
	disconnected: false,
	datetime: {
		date: '',
		time: '',
		holiday: ''
	},
	fans: {
		min: [],
		max: []
	},
	systemInfo: {
		cpu: {
			load: 40,
			frequency: 1000
		},
		memory: {
			used: 100,
			total: 1000,
			load: 11
		},
		temperatures: {
			cpu: 100,
			gpu: 100
		},
		processes: [],
		locked: true,
		gpu: {
			load: '0%',
			memory: {
				free: '10%',
				total: '2%'
			}
		},
		fans: []
	},
	hwInfo: {
		storages: [],
		gpu: '',
		cpu: '',
		kernel: '',
		distro: '',
		uptime: ''
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
			pes: {
				official: {
					score: 0,
					level: 1
				},
				current: {
					score: 0,
					level: 1
				}
			},
			cases: {
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
	currentPanel: localStorage.currentPanel ? localStorage.currentPanel : 1
};