(function(angular){
    angular.module('category')
        .factory('categoryService', ['$filter', function($filter) {
            var _categories;

            var _loaded = false;

            var _init = function(categories) {
                _categories = categories;
                _loaded = true;
            }

            var _isLoaded = function() {
                return _loaded;
            }

            var _findById = function(categoryId) {
                categoryId = parseInt(categoryId);
                return $filter('filter')(_categories, {id: categoryId}, true)[0];
            }

            var _findSubcategories = function(categoryId) {
                categoryId = parseInt(categoryId);
                if(0 === categoryId) {
                    categoryId = null;
                }
                return $filter('filter')(_categories, {parent_id: categoryId}, true);
            }

            var _findParents = function(categoryId) {
                var parents = [],
                    parent  = _findById(categoryId);

                while(parent.parent_id !== null) {
                    parent = _findById(parent.parent_id);
                    parents.unshift(parent);
                }

                return parents;
            }

            var _addCategory = function(category) {
                _categories.push(category);
            };

            var _replaceCategory = function(newCategory) {
                var oldCategoryId = parseInt(newCategory.id);
                _categories = $filter('filter')(_categories, function(category, index) {return category.id != oldCategoryId});
                _categories.push(newCategory);
            }

            return {
                init: _init,
                isLoaded: _isLoaded,
                findById: _findById,
                findSubcategories: _findSubcategories,
                findParents: _findParents,
                addCategory: _addCategory,
                replaceCategory: _replaceCategory
            };
        }]);
}(angular));