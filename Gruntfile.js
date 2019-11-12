module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-bake');
	grunt.loadNpmTasks('grunt-concat-css');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	
	var pkg = grunt.file.readJSON('package.json');
	grunt.log.write(pkg.libs);
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			jsLib: {
				src: pkg.libs.js,
				dest: 'build/libs.min.js'
			},
			js: {
				src: 'gui/js/*',
				dest: 'build/app.min.js'
			}
		},
		concat_css: {
			options: {
			},
			all: {
				src: ["gui/css/*"],
				dest: "build/app.min.less"
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
					'build/app.min.css': 'build/app.min.less'
				}
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
	});
	
	grunt.registerTask('default', ['uglify', 'concat_css', 'less', 'bake']);
	
}
