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
                files: {
                    'public/js/vendor.js' : [
                        'resources/assets/bower/jquery/dist/jquery.min.js',
                        'resources/assets/bower/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
                        'resources/assets/bower/angular/angular.min.js',
                        'resources/assets/bower/angular-ui-router/release/angular-ui-router.min.js'
                    ],
                    'public/js/app.js' : [
                        // App
                        'resources/assets/js/src/app.js',
                        'resources/assets/js/src/AppController.js',
                        'resources/assets/js/src/filters.js',

                         // Auth module
                            // Services
                        'resources/assets/js/src/Auth/Services/authHttpFacade.js',
                        'resources/assets/js/src/Auth/Services/authService.js',
                        'resources/assets/js/src/Auth/Services/sessionFactory.js',
                        'resources/assets/js/src/Auth/Services/userHttpFacade.js',
                           // Directives
                        'resources/assets/js/src/Auth/Directives/kvEmailExists.js',
                        'resources/assets/js/src/Auth/Directives/kvPasswordConfirm.js',
                        'resources/assets/js/src/Auth/Directives/kvUniqueEmail.js',
                            // Controllers
                        'resources/assets/js/src/Auth/Controllers/loginController.js',
                        
                         // Category module
                            // Services
                        'resources/assets/js/src/Category/Services/categoryHttpFacade.js',
                        'resources/assets/js/src/Category/Services/categoryService.js',

                            // Directives
                        'resources/assets/js/src/Category/Directives/kvBreadcrumbs.js',
                        'resources/assets/js/src/Category/Directives/kvSubcategories.js',
                        'resources/assets/js/src/Category/Directives/kvUniqueCategory.js',

                            // Controllers
                        'resources/assets/js/src/Category/Controllers/categoryController.js',
                        'resources/assets/js/src/Category/Controllers/editController.js',
                        'resources/assets/js/src/Category/Controllers/listController.js',

                        // Case module
                           // Services
                        'resources/assets/js/src/Case/Services/caseHttpFacade.js',
                        'resources/assets/js/src/Case/Services/providerHttpFacade.js',
                        'resources/assets/js/src/Case/Services/slideHttpFacade.js',

                           // Directives
                        'resources/assets/js/src/Case/Directives/kvUniqueUrl.js',

                            // Controllers
                        'resources/assets/js/src/Case/Controllers/editController.js',
                        'resources/assets/js/src/Case/Controllers/listController.js'
                    ]
                }
                
            }
        },

        phpunit: {
            unit: {
                dir: 'tests/unit'
            },
            integrated: {
                dir: 'tests/integrated'
            },
            options: {
                bin: 'vendor/bin/phpunit',
                colors: true
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

        watch: {
            sass: {
                files: './resources/assets/sass/**/*.{scss,sass}',
                tasks: ['sass:dev']
            },
            tests: {
                files: [
                    'app/**/*.php',
                    'tests/**/*.php'
                ],
                tasks: ['phpunit:integrated']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('styles', ['sass:dev', 'postcss', 'watch:sass']);
    grunt.registerTask('scripts', ['concat']);
    grunt.registerTask('tests', ['phpunit:integrated', 'watch:tests']);
};