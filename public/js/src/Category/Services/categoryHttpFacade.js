(function(angular, $) {
    angular.module('category')
        .factory('categoryHttpFacade', ['$http', '$q', function($http, $q) {
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
                return $http.get('/api/categories')
                    .then(_processSuccessResponse, _processErrorResponse);
            };

            var _checkExists = function(parentId, category) {
                parentId = parseInt(parentId, 10);
                return $http.get('/api/categories/check-existence/' + parentId + '/' + encodeURIComponent(category))
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

            var _save = function(category) {
                return $http({
                    method: 'POST',
                    url: '/api/categories',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(category)
                }).then(_processSuccessResponse, _processErrorResponse);
            };

            return {
                getAll: _getAll,
                checkExists: _checkExists,
                save: _save
            };
        }]);
}(angular, window.jQuery));
