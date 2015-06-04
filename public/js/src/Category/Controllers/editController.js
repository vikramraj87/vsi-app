(function(angular){
    function Category()
    {
        this.id = 0;
        this.category = "";
        this.parent_id = 0;
    }
    angular.module('category')
        .controller('CategoryEditController', ['$scope', 'categoryHttpFacade', '$routeParams', '$location', function($scope, categoryHttpFacade, $routeParams, $location) {
            $scope.$watch(function(scope) {
                return scope.category;
            }, function(nVal) {
                $scope.cat.parent_id = nVal !== null ? nVal.id : 0;
            });

            $scope.save = function() {
                categoryHttpFacade.save($scope.cat).then(function(savedCategory) {
                    $scope.replaceCategory({'id': savedCategory.id, 'category': savedCategory.category, 'parent_id': savedCategory.parent_id});
                    $scope.flashMsg('Category successfully updated.');
                    $location.path('/categories/' + savedCategory.parent_id);
                });
            }

            var _init = function() {
                $scope.cat = new Category();
                $scope.cat.parent_id = $scope.category !== null ? $scope.category.id : 0;

                if($routeParams.id) {
                    categoryHttpFacade.getById($routeParams.id).then(function(category) {
                        $scope.cat.id = category.id;
                        $scope.cat.parent_id = category.parent_id === null ? 0 : category.parent_id;
                        $scope.cat.category = category.category;

                        $scope.select($scope.cat.parent_id);
                    });
                }
            }

            _init();
        }]);
}(angular));