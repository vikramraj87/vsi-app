(function(angular){
    angular.module('case')
        .factory('slideHttpFacade', ['$http', '$q', function($http, $q) {
            var _check = function(url) {
                return $http.get('/api/slides/checkURL?url=' + encodeURIComponent(url))
                    .then(function(response) {
                        if(response.status === 200 && response.data.status === 'success') {
                            return true;
                        }
                        return false;
                    }, function(response) {
                        $q.reject(response.data);
                    });
            }

            return {
                check: _check
            };
        }]);
}(angular));