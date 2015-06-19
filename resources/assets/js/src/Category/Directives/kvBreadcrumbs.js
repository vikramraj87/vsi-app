(function(angular){
    angular.module('category')
        .directive('kvBreadcrumbs', function() {
            var _controller = ['$scope', '$state', function($scope, $state) {
                var _getUrl = function(categoryId) {
                    var params = $scope.params ? $scope.$eval($scope.params) : {};
                    params.id = categoryId;
                    return $state.href($state.current, params);
                };
                $scope.getUrl = _getUrl;
            }];

            return {
                scope: {
                    'ancestors': '=',
                    'category': '=',
                    'params': '@'
                },
                restrict: 'E',
                templateUrl: 'partials/category/_breadcrumbs.html',
                controller: _controller
            };
        });
}(angular));
