// Karma configuration
// Generated on Tue May 26 2015 23:02:07 GMT+0530 (IST)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
        'resources/assets/bower/jquery/dist/jquery.min.js',
        'resources/assets/bower/angular/angular.min.js',
        'resources/assets/bower/angular-mocks/angular-mocks.js',

        'public/js/src/app.js',

        'public/js/src/Case/Services/caseHttpFacade.js',
        'public/js/spec/Case/Services/caseHttpFacadeSpec.js',

        'public/js/src/Case/Services/slideHttpFacade.js',
        'public/js/spec/Case/Services/slideHttpFacadeSpec.js',

        'public/js/src/Category/Services/categoryHttpFacade.js',
        'public/js/spec/Category/Services/categoryHttpFacadeSpec.js',

        'public/js/src/Category/Controllers/categoryController.js',
        'public/js/spec/Category/Controllers/categoryControllerSpec.js'
    ],


    // list of files to exclude
    exclude: [
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['Chrome'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false
  });
};
