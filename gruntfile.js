var cssFiles = {
    'public/css/bootstrap.css': 'resources/assets/sass/bootstrap.scss',
    'public/css/app.css': 'resources/assets/sass/app.scss'
};

module.exports = function (grunt) {
    grunt.initConfig({
        concat: {
            options: {
                separator: ';\n'
            },
            dist: {
                src: [
                    'resources/assets/bower/jquery/dist/jquery.min.js',
                    'resources/assets/bower/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
                    'resources/assets/bower/angular/angular.min.js',
                    'resources/assets/bower/angular-route/angular-route.min.js'
                ],
                dest: './public/js/vendor.js'
            }
        },

        sass: {
            dev: {
                options: {
                    style: 'expanded'
                },
                files: cssFiles
            },
            dist: {
                options: {
                    style:'compressed'
                },
                files: cssFiles
            }
        },

        postcss: {
            options: {
                map: true,
                processors: [
                    require('autoprefixer-core')({browsers: 'last 2 version'}).postcss
                ],
                dist: {
                    src: 'public/css/bootstrap.css'
                }
            }
        },

        // Options for grunt-phpspec
        //phpspec: {
        //    options: {
        //        prefix: './vendor/bin/'
        //    },
        //    kivi: {
        //        specs: 'app/Kivi'
        //    }
        //},

        // Options for grunt-notify
        //notify: {
        //    phpspec: {
        //        options: {
        //            title: 'PHPSpec: Oops!',
        //            message: 'Error in your code boss.'
        //        }
        //    }
        //},

        watch: {
            sass: {
                files: './resources/assets/sass/**/*.{scss,sass}',
                tasks: ['sass:dev']
            }
            //phpspec: {
            //    files: [
            //        'app/Kivi/**/*.php',
            //        'app/spec/**/*.php'
            //    ],
            //    tasks: ['phpspec:kivi']
            //}
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-watch');

    //grunt.loadNpmTasks('grunt-phpspec');
    ////grunt.loadNpmTasks('grunt-notify');

    //grunt.registerTask('css', ['sass', 'watch:sass']);
    //grunt.registerTask('testing', ['phpspec:kivi', 'watch:phpspec']);

    grunt.registerTask('styles', ['sass:dev', 'postcss', 'watch:sass']);
    grunt.registerTask('scripts', ['concat']);
};