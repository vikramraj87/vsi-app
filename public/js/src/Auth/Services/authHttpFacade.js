(function(angular){
    angular.module('auth')
        .factory('authHttpFacade', ['$http', '$q', function($http, $q) {
            var AUTH_USER   = '/api/auth/user',
                LOGIN_USER  = '/api/auth/login',
                LOGOUT_USER = '/api/auth/logout';

            var _success = function(response) {
                if(response.status !== 200) {
                    return $q.reject(response);
                }
                if(typeof response.data !== 'object') {
                    return $q.reject(response.data);
                }
                if(response.data.status === 'fail') {
                    return $q.reject(response.data.data);
                }
                return response.data.data;
            };

            var _fetchAuthenticatedUser = function() {
                return $http.get(AUTH_USER).then(_success);
            };

            var _loginUser = function(email, password) {
                return $http({
                    method: 'POST',
                    url: LOGIN_USER,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param({
                        email: email,
                        password: password
                    })
                }).then(_success);
            };

            var _logoutUser = function() {
                return $http.get(LOGOUT_USER).then(_success);
            };

            return {
                fetchUser: _fetchAuthenticatedUser,
                loginUser: _loginUser,
                logoutUser: _logoutUser
            };
        }]);
}(angular));
