(function(angular) {
    var caseModule = angular.module('case');
    caseModule.service(
        'categoryService',
        [
            '$filter',
            function($filter) {
                this._categories = [];

                this.init = function(categories) {
                    this._categories = categories;
                };

                this.findCategory = function(categoryId) {
                    categoryId = parseInt(categoryId);
                    return $filter('filter')(this._categories, {id: categoryId}, true)[0];
                };

                this.findSubcategories = function(categoryId) {
                    categoryId = parseInt(categoryId);
                    if(categoryId == 0) {
                        return $filter('filter')(this._categories, {parent_id: null}, true);
                    }
                    return $filter('filter')(this._categories, {parent_id: categoryId}, true);
                };

                this.findParents = function(category) {
                    var parents = [],
                        parent  = category;

                    parents.push(parent);
                    while(parent.parent_id !== null) {
                        parent = this.findCategory(parent.parent_id);
                        parents.unshift(parent);
                    }

                    return parents;
                };
            }
        ]
    );
}(angular));