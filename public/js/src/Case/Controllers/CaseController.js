(function(angular) {
    var caseModule = angular.module('case');
    caseModule.controller(
        'CaseController',
        [
            '$scope',
            'caseHttpFacade',
            function($scope, caseHttpFacade) {
                $scope.cases = [];

                $scope.$watch(
                    function(scope) {
                        return scope.category;
                    }, function(newValue, oldValue) {
                        var categoryId = (newValue !== null) ? newValue.id : 0,
                            responsePromise = caseHttpFacade.getCases(categoryId);
                        $scope.cases = [];
                        responsePromise.then(function(response) {
                            $scope.cases = response.data;
                        }).catch(function(response) {

                        }).finally(function() {

                        });
                    });
            }
        ]
    );
} (angular));