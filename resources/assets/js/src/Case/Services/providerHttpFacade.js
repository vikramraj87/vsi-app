(function(angular) {
    angular.module('case')
        .factory('providerHttpFacade', ['$http', '$q', function($http, $q) {

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
                return $http.get('/api/providers', {cache: true}).then(_processSuccessResponse, _processErrorResponse)
            };

            return {
                getAll: _getAll
            };
        }]);
}(angular));