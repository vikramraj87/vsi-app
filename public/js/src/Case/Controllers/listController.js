(function(angular){
    angular.module('case')
        .controller('CaseListController', ['$scope', 'caseHttpFacade', '$timeout', function($scope, caseHttpFacade, $timeout){
        $scope.cases = [];

        $scope.$watch(function(scope) {
            return scope.category;
        }, function(nVal, oVal) {
            var categoryId = (nVal !== null) ? nVal.id : 0;
            caseHttpFacade.getCases(categoryId).then(function(cases) {
                $scope.cases = cases;
            });
        });
    }]);
}(angular));