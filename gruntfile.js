module.exports = function (grunt) {
    grunt.initConfig({
        // Load the package.json as pkg
        pkg: grunt.file.readJSON('package.json'),

        // Options for grunt-contrib-concat
        concat: {
            options: {
                separator: ';\n'
            },
            dist: {
                src: [
                    './resources/assets/bower/jquery/dist/jquery.min.js',
                    './resources/assets/bower/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
                    './resources/assets/bower/handlebars/handlebars.min.js'
                ],
                dest: './public/js/vendor.js'
            }
        },

        // Options for grunt-contrib-sass
        sass: {
            dev: {
                options: {
                    style: 'expanded'
                },
                files: {
                    './public/css/app.css': './resources/assets/sass/app.scss'
                }
            },
            dist: {
                options: {
                    style:'compressed'
                },
                files: {
                    './public/css/app.css': './resources/assets/sass/app.scss'
                }
            }
        },

        // Options for grunt-phpspec
        phpspec: {
            options: {
                prefix: './vendor/bin/'
            },
            kivi: {
                specs: 'app/Kivi'
            }
        },

        // Options for grunt-notify
        //notify: {
        //    phpspec: {
        //        options: {
        //            title: 'PHPSpec: Oops!',
        //            message: 'Error in your code boss.'
        //        }
        //    }
        //},

        // Options for grunt-contrib-watch
        watch: {
            sass: {
                files: './resources/assets/sass/**/*.{scss,sass}',
                tasks: ['sass:dist']
            },
            phpspec: {
                files: [
                    'app/Kivi/**/*.php',
                    'app/spec/**/*.php'
                ],
                tasks: ['phpspec:kivi']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpspec');
    //grunt.loadNpmTasks('grunt-notify');

    grunt.registerTask('css', ['sass', 'watch:sass']);
    grunt.registerTask('testing', ['phpspec:kivi', 'watch:phpspec']);
};