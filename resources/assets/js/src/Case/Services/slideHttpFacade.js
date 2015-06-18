(function(angular){
    angular.module('case')
        .factory('slideHttpFacade', ['$http', '$q', function($http, $q) {
            var _checkExists = function(url, exceptId) {
                if(exceptId === undefined) {
                    exceptId = 0;
                }
                exceptId = parseInt(exceptId, 10);
                return $http.get('/api/slides/check-url-existence/' + exceptId + '?url=' + encodeURIComponent(url))
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
                    }, function(response) {
                        $q.reject(response.data);
                    });
            }

            return {
                checkExists: _checkExists
            };
        }]);
}(angular));