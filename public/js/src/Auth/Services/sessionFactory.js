(function(angular){
    angular.module('auth')
        .factory('sessionFactory', function() {
            var _user = null;

            var _setUser = function(user) {
                _user = user;
            };

            var _getUser = function() {
                return _user;
            };

            return {
                setUser: _setUser,
                user: _getUser
            };
        });
}(angular));
