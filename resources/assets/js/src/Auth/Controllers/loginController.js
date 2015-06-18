(function(angular){
    angular.module('auth')
        .controller('AuthLoginController', [
            '$scope', '$rootScope', 'authHttpFacade', 'sessionFactory', 'authService',
            function($scope, $rootScope, authHttpFacade, sessionFactory, authService) {
                $scope.credentials = null;
                $scope.invalidCredentials = false;

                $scope.login = function(credentials) {
                    if($scope.loginForm.$invalid) {
                        return;
                    }
                    authHttpFacade.loginUser(credentials.email, credentials.password).then(function(user) {
                        sessionFactory.setUser(user);
                        $rootScope.$broadcast('UserFetched');
                    }, function(error) {
                        if(error.reason === 'InvalidCredentials') {
                            $scope.invalidCredentials = true;
                            $scope.credentials.password = "";
                        }
                    });
                }
            }
        ]);
}(angular));
