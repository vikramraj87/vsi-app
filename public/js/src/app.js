angular
    .module('app', ['case', 'ngRoute'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }).config(function($routeProvider) {
        $routeProvider.when('/category/edit/id', {
            templateUrl: 'partial/category-edit.html',
            controller: 'CaseController'
        });
        $routeProvider.when('case/edit/id', {
            templateUrl: 'partial/case-edit.html',
            controller: 'CaseController'
        });
    });
angular.module('case', []);