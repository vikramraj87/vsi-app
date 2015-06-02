angular.module('app', ['case', 'category', 'ngRoute'])
    .config(function($routeProvider, $locationProvider) {
        $routeProvider.when('/cases/create', {
            templateUrl: 'partials/case/edit.html',
            controller: 'CaseEditController'
        });

        $routeProvider.when('/cases', {
            templateUrl: 'partials/case/list.html',
            controller: 'CaseListController'
        });

        $routeProvider.when('/categories/create', {
            templateUrl: 'partials/category/create.html',
            controller: 'CategoryCreateController'
        });

        $routeProvider.otherwise({
            redirectTo: '/cases'
        });

        $locationProvider.html5Mode(true);
    });
angular.module('case', []);
angular.module('category', []);