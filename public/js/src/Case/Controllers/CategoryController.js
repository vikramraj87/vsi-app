(function(angular){
    angular.module('case')
        .controller('CategoryController', ['$scope', 'categoryHttpFacade', '$filter', function($scope, categoryHttpFacade, $filter) {
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

            var _init = function() {
                categoryHttpFacade.getAll().then(function(categories) {
                    _categories = categories;
                    _select(0);
                });
            };

            _init();
        }]);
}(angular));