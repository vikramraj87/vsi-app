(function(angular){
    var caseModule = angular.module('case');
    caseModule.controller(
        'CategoryController',
        [
            '$scope',
            'categoryService',
            'categoryHttpFacade',
            function($scope, categoryService, categoryHttpFacade) {

                $scope.parents  = [];
                $scope.category = null;
                $scope.children = [];
                $scope.select   = null;

                var select = function(categoryId) {
                    categoryId = parseInt(categoryId, 10);
                    if(categoryId === 0) {
                        $scope.parents  = [];
                        $scope.category = null;
                        $scope.children = categoryService.findSubcategories(categoryId);
                        return;
                    }

                    var category = categoryService.findCategory(categoryId);

                    $scope.category = category;
                    $scope.parents  = categoryService.findParents(category);
                    $scope.children = categoryService.findSubcategories(categoryId);
                };

                $scope.select = select;

                var getCategoriesPromise = categoryHttpFacade.getAllCategories();
                getCategoriesPromise
                    .then(function(response) {
                        categoryService.init(response.data);
                        select(0);
                    }).catch(function(response) {

                    }).finally(function() {

                    });
            }
        ]
    );
}(angular));