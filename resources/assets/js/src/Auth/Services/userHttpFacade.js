(function(angular){
    angular.module('auth')
        .factory('userHttpFacade', ['$http', '$q', function($http) {
            var CHECK = '/api/users/check-email/:email';

            var _checkEmail = function(email) {
                return $http.get(CHECK.replace(':email', encodeURIComponent(email))).then(function(response) {
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
                });
            }

            return {
                checkEmail: _checkEmail
            };
    }]);
}(angular));
