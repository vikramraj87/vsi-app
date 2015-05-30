//angular
//    .module('app', ['case', 'ngRoute'], function($interpolateProvider) {
//        $interpolateProvider.startSymbol('<%');
//        $interpolateProvider.endSymbol('%>');
//    }).config(function($routeProvider) {
//        /*
//         * Case routes
//         */
//        $routeProvider.when('/case/edit/:id', {
//            templateUrl: 'partial/case/edit.html',
//            controller: 'editController'
//        });
//
//        $routeProvider.when('/case/create', {
//            templateUrl: 'partial/case/edit.html',
//            controller: 'editController'
//        });
//
//        $routeProvider.when('/cases/category/:categoryId', {
//            templateUrl: 'partial/case/list.html',
//            controller: 'listController'
//        });
//
//        $routeProvider.when('/cases', {
//            templateUrl: 'partial/case/list.html',
//            controller: 'listController'
//        });
//
//        $routeProvider.otherwise({
//            redirectTo: '/cases'
//        });
//    });
angular.module('app', ['case', 'ngRoute'])
    .config(function($routeProvider, $locationProvider) {
        $routeProvider.when('/cases', {
            templateUrl: 'partial/case/list.html',
            controller: 'ListController'
        });

        $routeProvider.otherwise({
            redirectTo: '/cases'
        });

        $locationProvider.html5Mode(true);
    });
angular.module('case', []);