(function(angular){
    angular.module('category')
        .controller('CategoryController', ['$scope', 'categoryHttpFacade', '$filter', '$timeout', function($scope, categoryHttpFacade, $filter, $timeout) {
            // Holds all the categories
            var _categories;

            // Initial state of the scope
            $scope.parents = [];
            $scope.category = null;
            $scope.children = [];

            // Filters one category from all categories by category Id
            var _findById = function(categoryId) {
                categoryId = parseInt(categoryId, 10);
                return $filter('filter')(_categories, {id: categoryId}, true)[0];
            }

            // Gets all direct subcategories of category
            var _findSubcategories = function(categoryId) {
                    categoryId = parseInt(categoryId);
                    if(categoryId == 0) {
                        return $filter('filter')(_categories, {parent_id: null}, true);
                    }
                    return $filter('filter')(_categories, {parent_id: categoryId}, true);
                };

            // Gets all ancestors for the selected category
            var _findParents = function(category) {
                var parents = [],
                    parent  = category;

                while(parent.parent_id !== null) {
                    parent = _findById(parent.parent_id);
                    parents.unshift(parent);
                }

                return parents;
            };

            // Scope function to change the selected category
            var _select = function(categoryId) {
                categoryId = parseInt(categoryId, 10);

                $scope.children = _findSubcategories(categoryId);

                if(categoryId === 0) {
                    $scope.parents = [];
                    $scope.category = null;
                    return;
                }

                $scope.category = _findById(categoryId);
                $scope.parents = _findParents($scope.category);
            }

            $scope.select = _select;

            $scope.flash = "";

            var _flashMsg = function(message) {
                $scope.flash = message;
                $timeout(function() {
                    $scope.flash = "";
                }, 5000);
            }

            $scope.flashMsg = _flashMsg;

            var _addCategory = function(category) {
                _categories.push(category);
                $scope.children = _findSubcategories(category.parent_id);
            };

            var _replaceCategory = function(newCategory) {
                var oldCategoryId = parseInt(newCategory.id);
                _categories = $filter('filter')(_categories, function(category, index) {return category.id != oldCategoryId});
                _categories.push(newCategory);
                $scope.children = _findSubcategories(newCategory.parent_id);
            }

            $scope.addCategory = _addCategory;
            $scope.replaceCategory = _replaceCategory;

            var _init = function() {
                categoryHttpFacade.getAll().then(function(categories) {
                    _categories = categories;
                    _select(0);
                    $scope.$broadcast('CategoriesLoaded');
                });
            };

            _init();
        }]);
}(angular));