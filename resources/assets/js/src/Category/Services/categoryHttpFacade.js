(function(angular, $) {
    angular.module('category')
        .factory('categoryHttpFacade', ['$http', '$q', function($http, $q) {
            var INDEX  = '/api/categories',
                SHOW   = '/api/categories/:categoryId',
                CHECK  = '/api/categories/check-existence/:parentId/:category/:excludeId',
                STORE  = '/api/categories',
                UPDATE = '/api/categories/:categoryId';

            var _processSuccessResponse = function(response) {
                if(response.status === 200 && typeof response.data === 'object' && response.data.status === 'success') {
                    return response.data.data;
                }
                if(response.data.status === 'fail') {
                    return $q.reject(response.data.data);
                }
            };

            var _processErrorResponse = function(response) {
                return $q.reject(response.data.data)
            }

            var _getAll = function() {
                return $http.get(INDEX)
                    .then(_processSuccessResponse, _processErrorResponse);
            };

            var _getById = function(categoryId) {
                return $http.get(SHOW.replace(':categoryId', categoryId))
                    .then(_processSuccessResponse, _processErrorResponse);
            }

            var _checkExists = function(parentId, category, excludeId) {
                parentId = parseInt(parentId, 10);

               if(isNaN(excludeId)) {
                   excludeId = 0;
               }

                var url = CHECK.replace(':parentId', parentId);
                url = url.replace(':category', encodeURIComponent(category));
                url = url.replace(':excludeId', excludeId);

                return $http.get(url)
                    .then(function(response) {
                        if(response.status !== 200) {
                            $q.reject(response.data);
                        }
                        if(typeof response.data !== 'object') {
                            $q.reject(response.data);
                        }
                        if(response.data.status === 'fail') {
                            return true;
                        }
                        return false;
                    })
            };

            var _createCategory = function(category) {
                delete category.id;
                return $http({
                    method: 'POST',
                    url: STORE,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(category)
                }).then(_processSuccessResponse, _processErrorResponse);
            };

            var _updateCategory = function(category) {
                var id = category.id;
                delete category.id;

                return $http({
                    method: 'PUT',
                    url: UPDATE.replace(':categoryId', id),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(category)
                }).then(_processSuccessResponse, _processErrorResponse);
            };

            var _save = function(category) {
                if(!category.id) {
                    return _createCategory(category);
                }
                return _updateCategory(category);
            };

            return {
                getAll: _getAll,
                checkExists: _checkExists,
                save: _save,
                getById: _getById
            };
        }]);
}(angular, window.jQuery));
