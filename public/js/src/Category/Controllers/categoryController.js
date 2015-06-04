(function(angular){
    angular.module('category')
        .controller('CategoryController', [
            '$scope', 'categoryHttpFacade', 'categoryService', '$filter', '$timeout',
            function($scope, categoryHttpFacade, categoryService, $filter, $timeout) {

                // Initial state of the scope
                $scope.parents = [];
                $scope.category = null;
                $scope.children = [];

                $scope.flash = "";

                // Scope function to change the selected category
                var _select = function(categoryId) {
                    categoryId = parseInt(categoryId, 10);
                    $scope.children = categoryService.findSubcategories(categoryId);

                    if(categoryId === 0) {
                        $scope.parents = [];
                        $scope.category = null;
                        return;
                    }

                    $scope.category = categoryService.findById(categoryId);
                    $scope.parents = categoryService.findParents(categoryId);
                }
                $scope.select = _select;

                var _flashMsg = function(message) {
                    $scope.flash = message;
                    $timeout(function() {
                        $scope.flash = "";
                    }, 5000);
                }
                $scope.flashMsg = _flashMsg;

                var _addCategory = function(category) {
                    categoryService.addCategory(category);
                    $scope.children = categoryService.findSubcategories(category.parent_id);
                };
                $scope.addCategory = _addCategory;

                var _replaceCategory = function(newCategory) {
                    categoryService.replaceCategory(newCategory);
                    $scope.children = categoryService.findSubcategories(newCategory.parent_id);
                }
                $scope.replaceCategory = _replaceCategory;

                var _init = function() {
                    categoryHttpFacade.getAll().then(function(categories) {
                        categoryService.init(categories);
                        _select(0);
                        $scope.$broadcast('CategoriesLoaded');
                    });
                };

                _init();
            }
        ]);
}(angular));