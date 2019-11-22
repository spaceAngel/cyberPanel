module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-bake');
	grunt.loadNpmTasks('grunt-concat-css');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-phpmd');
	
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
				cwd: 'node_modules/font-awesome/fonts',
				src: "*",
				dest: 'build/fonts'
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
					host: '192.168.0.2',
					port: 9000,
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
		}
		
	});
	
	grunt.registerTask('default', ['uglify', 'concat_css', 'less', 'bake', 'copy']);
	
}
