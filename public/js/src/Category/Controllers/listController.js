(function(angular){
    function Category()
    {
        this.category = "";
        this.parent_id = 0;
    }
    angular.module('category')
        .controller('CategoryListController', ['$scope', '$routeParams', 'categoryHttpFacade', function($scope, $routeParams, categoryHttpFacade) {
            var _init = function() {
                $scope.cat = new Category();
                $scope.cat.parent_id = $scope.category !== null ? $scope.category.id : 0;
            }
            _init();

            $scope.$watch(function(scope) {
                return scope.category;
            }, function(nVal) {
                $scope.cat.parent_id = nVal !== null ? nVal.id : 0;
            });

            $scope.$on('CategoriesLoaded', function(event, data) {
                if($routeParams.parentId) {
                    $scope.select($routeParams.parentId);
                }
            });

            $scope.save = function() {
                categoryHttpFacade.save($scope.cat).then(function(savedCategory) {
                    $scope.addCategory({'id': savedCategory.id, 'category': savedCategory.category, 'parent_id': savedCategory.parent_id});
                    $scope.flashMsg('Category successfully created.');
                    _init();
            });
        }
        }]);
}(angular));