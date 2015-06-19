(function(angular){
    angular.module('app')
        .controller('AppController', [
            '$scope', '$rootScope', '$state', 'authHttpFacade', 'sessionFactory',
            function($scope, $rootScope, $state, authHttpFacade, sessionFactory) {
                $scope.user = null;

                $rootScope.$on('$stateChangeStart', function(event, toState, toParams) {
                    if(! _checkAccess(toState)) {
                        event.preventDefault();
                        $state.go('start');
                    }
                });

                $rootScope.$on('UserLoggedOut', function() {
                    if(! _checkAccess($state.current)) {
                        $state.go('start');
                    }
                });

                $scope.$on('UserFetched', function() {
                    if($state.current.name && ! _checkAccess($state.current)) {
                        $state.go('start');
                    }
                    $scope.user = sessionFactory.user();
                });

                var _checkAccess = function(state) {
                    if(typeof state === 'string') {
                        if(null === $state.get(state)) {
                            throw new Error('The state "' + state + '" does not exists');
                        }
                        state = $state.get(state);
                    }
                    var user = sessionFactory.user(),
                        role = null === user ? 'Guest' : user.role.role,
                        access = state.data.access;
                    return access.indexOf(role) !== -1;
                };

                $scope.checkAccess = _checkAccess;

                var _logout = function() {
                    var user = sessionFactory.user();
                    if(null !== user) {
                        authHttpFacade.logoutUser().then(function(response) {
                            sessionFactory.setUser(null);
                            $scope.user = null;
                            $rootScope.$broadcast('UserLoggedOut');
                        });
                    }
                };

                $scope.logout = _logout;

                var _init = function() {
                    authHttpFacade.fetchUser().then(function(user) {
                        sessionFactory.setUser(user);
                        $scope.user = user;
                        $rootScope.$broadcast('UserFetched');
                    });
                };

                _init();
            }
        ]);
}(angular));
