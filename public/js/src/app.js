angular.module('app', ['case', 'category', 'ngRoute'])
    .constant('Api', {
        'Categories': {
            'Index': '/api/categories',
            'Show': '/api/categories/:categoryId',
            'CheckExistence': '/api/categories/check-existence/:parentId/:category/:excludeId',
            'Store': '/api/categories',
            'Update': '/api/categories/:categoryId'
        }
    })
    .config(function($routeProvider, $locationProvider) {
        $routeProvider.when('/cases/create', {
            templateUrl: 'partials/case/edit.html',
            controller: 'CaseEditController'
        });

        $routeProvider.when('/cases', {
            templateUrl: 'partials/case/list.html',
            controller: 'CaseListController'
        });

        $routeProvider.when('/categories/edit/:id', {
            templateUrl: 'partials/category/edit.html',
            controller: 'CategoryEditController'
        });

        $routeProvider.when('/categories/create', {
            templateUrl: 'partials/category/edit.html',
            controller: 'CategoryEditController'
        });

        $routeProvider.when('/categories/:parentId?', {
            templateUrl: 'partials/category/list.html',
            controller: 'CategoryListController'
        });

        $routeProvider.otherwise({
            redirectTo: '/cases'
        });

        $locationProvider.html5Mode(true);
    });
angular.module('case', []);
angular.module('category', []);