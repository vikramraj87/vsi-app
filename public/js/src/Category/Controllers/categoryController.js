(function(angular){
    angular.module('category')
        .controller('CategoryController', [
            '$scope', 'categoryHttpFacade', 'categoryService', '$filter', '$timeout', '$stateParams', '$state',
            function($scope, categoryHttpFacade, categoryService, $filter, $timeout, $stateParams, $state) {

                // Initial state of the scope
                $scope.parents = [];
                $scope.category = null;
                $scope.children = [];

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

                var _flashMsg = function(message) {
                    $scope.flash = message;
                    $timeout(function() {
                        $scope.flash = "";
                    }, 5000);
                }

                var _addCategory = function(category) {
                    categoryService.addCategory(category);
                    $scope.children = categoryService.findSubcategories(category.parent_id);
                };

                $scope.$on('CategoryAdded', function(event, args) {
                    _addCategory(args.addedCategory);
                });

                var _replaceCategory = function(newCategory) {
                    categoryService.replaceCategory(newCategory);
                    $scope.children = categoryService.findSubcategories(newCategory.parent_id);
                }

                $scope.$on('CategoryEdited', function(event, args) {
                    _replaceCategory(args.editedCategory);
                    $state.go('category.category-list', {id: args.editedCategory.parent_id});
                });

                var _init = function() {
                    if(!categoryService.isLoaded()) {
                        categoryHttpFacade.getAll().then(function(categories) {
                            categoryService.init(categories);
                            _select($stateParams.id);
                            $scope.$broadcast('CategoriesLoaded');
                        });
                        return;
                    }
                    _select($stateParams.id);
                };

                _init();
            }
        ]);
}(angular));