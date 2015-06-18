(function(angular){
    angular.module('case')
        .controller('CaseListController', [
            '$scope', 'cases',
            function($scope, cases)
            {
                $scope.cases = cases;
            }
        ]
    );
}(angular));