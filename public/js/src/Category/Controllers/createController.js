(function(angular){
    function Category()
    {
        this.category = "";
        this.parent_id = 0;
    }
    angular.module('category')
        .controller('CategoryCreateController', ['$scope', 'categoryHttpFacade', function($scope, categoryHttpFacade) {
            $scope.$watch(function(scope) {
                return scope.category;
            }, function(nVal) {
                $scope.cat.parent_id = nVal !== null ? nVal.id : 0;
            });

            $scope.save = function() {
                categoryHttpFacade.save($scope.cat).then(function(savedCategory) {
                    _init();
                    $scope.addCategory({'id': savedCategory.id, 'category': savedCategory.category, 'parent_id': savedCategory.parent_id});
                    $scope.flashMsg('Category successfully created.');
                });
            }

            var _init = function() {
                $scope.cat = new Category();
                $scope.cat.parent_id = $scope.category !== null ? $scope.category.id : 0;
            }

            _init();
        }]);
}(angular));