(function(angular){
    angular.module('category')
        .controller('CategoryListController', [
            '$scope', '$rootScope', 'categoryHttpFacade',
            function($scope, $rootScope, categoryHttpFacade) {
                $scope.save = function(category) {
                    if($scope.createCategoryForm.$valid) {
                        categoryHttpFacade.save(category).then(function(savedCategory) {
                            $rootScope.$broadcast('CategoryAdded', {addedCategory: savedCategory});
                            _init();
                        });
                    }
                };

                var _init = function() {
                    $scope.cat = new Category();
                    $scope.cat.parent_id = $scope.category !== null ? $scope.category.id : 0;
                    if($scope.createCategoryForm) {
                        $scope.createCategoryForm.$setPristine();
                    }
                };
                _init();
            }
        ]
    );
}(angular));