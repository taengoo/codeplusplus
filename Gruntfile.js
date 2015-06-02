
module.exports = function (grunt) {
  'use strict';
  
  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  grunt.initConfig({

    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*!\n' +
            ' * Test Bootstrap Theme v<%= pkg.version %>\n' +
            ' * Copyright <%= grunt.template.today("yyyy") %>\n' +
            ' */\n',
    // NOTE: This jqueryCheck code is duplicated in customizer.js; if making changes here, be sure to update the other copy too.
    jqueryCheck: 'if (typeof jQuery === \'undefined\') { throw new Error(\'Bootstrap\\\'s JavaScript requires jQuery\') }\n\n',

    // Task configuration.
    clean: {
      dist: ['public/dist']
    },

    concat: {
      options: {
        banner: '<%= banner %>\n<%= jqueryCheck %>',
        stripBanners: false
      },
      bootstrap: {
        src: [
          'assets/js/transition.js',
          'assets/js/alert.js',
          'assets/js/button.js',
          'assets/js/carousel.js',
          'assets/js/collapse.js',
          'assets/js/dropdown.js',
          'assets/js/tooltip.js',
          'assets/js/popover.js',
          'assets/js/scrollspy.js',
          'assets/js/tab.js',
          'assets/js/affix.js'
        ],
        dest: 'public/dist/js/<%= pkg.name %>.js'
      }
    },

    uglify: {
      options: {
        preserveComments: 'some'
      },
      bootstrap: {
        src: '<%= concat.bootstrap.dest %>',
        dest: 'public/dist/js/<%= pkg.name %>.min.js'
      }
    },

    less: {
      compileCore: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: '<%= pkg.name %>.css.map',
          sourceMapFilename: 'public/dist/css/<%= pkg.name %>.css.map'
        },
        src: 'assets/less/bootstrap.less',
        dest: 'public/dist/css/<%= pkg.name %>.css'
      },
      compileDefaultTheme: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: '<%= pkg.name %>-theme.css.map',
          sourceMapFilename: 'public/dist/css/<%= pkg.name %>-theme.css.map'
        },
        src: 'assets/less/theme.less',
        dest: 'public/dist/css/<%= pkg.name %>-theme.css'
      }
    },

    autoprefixer: {
      options: {
        browsers: [
          'Android 2.3',
          'Android >= 4',
          'Chrome >= 20',
          'Firefox >= 24', // Firefox 24 is the latest ESR
          'Explorer >= 8',
          'iOS >= 6',
          'Opera >= 12',
          'Safari >= 6'
        ]
      },
      core: {
        options: {
          map: true
        },
        src: 'public/dist/css/<%= pkg.name %>.css'
      },
      defaultTheme: {
        options: {
          map: true
        },
        src: 'public/dist/css/<%= pkg.name %>-theme.css'
      }
    },

    cssmin: {
      options: {
        compatibility: 'ie8',
        keepSpecialComments: '*',
        noAdvanced: true
      },
      minifyCore: {
        src: 'public/dist/css/<%= pkg.name %>.css',
        dest: 'public/dist/css/<%= pkg.name %>.min.css'
      },
      minifyDefaultTheme: {
        src: 'public/dist/css/<%= pkg.name %>-theme.css',
        dest: 'public/dist/css/<%= pkg.name %>-theme.min.css'
      }
    },

    usebanner: {
      options: {
        position: 'top',
        banner: '<%= banner %>'
      },
      files: {
        src: 'public/dist/css/*.css'
      }
    },

    csscomb: {
      options: {
        config: 'assets/less/.csscomb.json'
      },
      dist: {
        expand: true,
        cwd: 'public/dist/css/',
        src: ['*.css', '!*.min.css'],
        dest: 'public/dist/css/'
      }
    },

    copy: {
      fonts: {
        expand: true,
		flatten: true,
        src: 'assets/fonts/**',
        dest: 'public/dist/fonts/',
		filter: 'isFile'
      }
    }
  });

  // These plugins provide necessary tasks.
  require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });
  require('time-grunt')(grunt);

  // JS distribution task.
  grunt.registerTask('dist-js', ['concat', 'uglify:bootstrap']);

  // CSS distribution task.
  grunt.registerTask('less-compile', ['less:compileCore', 'less:compileDefaultTheme']);
  grunt.registerTask('dist-css', ['less-compile', 'autoprefixer', 'usebanner', 'csscomb', 'cssmin']);

  // Full distribution task.
  grunt.registerTask('dist', ['clean', 'dist-css', 'copy:fonts', 'dist-js']);
  
  grunt.registerTask('dist-emanga-js', ['uglify:emanga']);  
};
