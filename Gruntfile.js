module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-bake');
	grunt.loadNpmTasks('grunt-concat-css');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-phpmd');
	grunt.loadNpmTasks('grunt-phpcs');
	grunt.loadNpmTasks('grunt-phpstan');


	
	var pkg = grunt.file.readJSON('package.json');
	grunt.log.write(pkg.libs);
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			jsLib: {
				src: pkg.libs.js,
				dest: 'build/js/libs.min.js'
			},
			js: {
				src: 'gui/js/**/*.js',
				dest: 'build/js/app.min.js'
			}
		},
		concat_css: {
			options: {
			},
			all: {
				src: ["gui/css/*"],
				dest: "build/css/app.min.less"
			},

			libs: {
				src: pkg.libs.css,
				dest: "build/css/libs.min.css"
			},
		},
	
		bake: {
			bake: {
				files: {
					"build/index.html": "gui/index.html",
				}
			}	
		},	
		less: {
			app: {
				files: {
					'build/css/app.min.css': 'build/css/app.min.less'
				}
			},
		},
		
		copy: {
			images: {
				expand: true,
				cwd: 'gui/images',
				src: "*",
				dest: 'build/images'
			},
			fa: {
				expand: true,
				cwd: 'node_modules/@fortawesome/fontawesome-free/webfonts',
				src: "*",
				dest: 'build/webfonts'
			},
			svg: {
				expand: true,
				cwd: 'gui/svg',
				src: "*",
				dest: 'build/svg'
			},
			fonts: {
				expand: true,
				cwd: 'gui/fonts',
				src: "*",
				dest: 'build/fonts'
			},
			sounds: {
				expand: true,
				cwd: 'gui/sounds',
				src: "*",
				dest: 'build/sounds'
			},
		},
			
		watch: {
			scripts: {
				files: ['gui/**/*'],
				tasks: ['default'],
				options: {
					spawn: false,
					livereload: true
				},
				livereload: {
				
				}
			},
		},
		
		phpmd: {
			application: {
				dir: 'src'
			},
			options: {
				bin: 'vendor/bin/phpmd',
				reportFormat: 'text',
				rulesets: 'phpmd.xml'
			}
		},
		phpcs: {
			application: {
				src: ['src/**/*.php']
			},
			options: {
				bin: 'vendor/bin/phpcs',
				standard: 'phpcs.xml'
			}
		},
		phpstan: {
			options: {
				level: "max",
				bin: "vendor/bin/phpstan"
			},
			php: {
				src: ["src/**/*.php"]
			}
		}
	});
	
	grunt.registerTask('default', ['uglify', 'concat_css', 'less', 'bake', 'copy']);
	grunt.registerTask('codecheck', [ 'phpcs', 'phpmd', 'phpstan']);
	
}
