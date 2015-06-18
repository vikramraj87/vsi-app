(function(angular){
    angular.module('category')
        .directive('kvSubcategories', function() {
            var FILTER_AFTER = 6;

            var _controller = ['$scope', '$state', function($scope, $state) {
                $scope.except = $scope.except ? parseInt($scope.except, 10) : 0;
                $scope.filterAfter = $scope.filterAfter ? parseInt($scope.filterAfter, 10) : FILTER_AFTER;

                var _getUrl = function(categoryId) {
                    var params = $scope.params ? $scope.$eval($scope.params) : {};
                    params.id = categoryId;
                    return $state.href($state.current, params);
                }
                $scope.getUrl = _getUrl;
            }];

            return {
                scope: {
                    'subcategories': '=',
                    'except': '@',
                    'filterAfter': '@',
                    'params': '@'
                },
                restrict: 'E',
                templateUrl: 'partials/category/_subcategories.html',
                controller: _controller
            };
        });
}(angular));
