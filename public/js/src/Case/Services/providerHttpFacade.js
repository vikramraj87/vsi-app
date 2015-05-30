(function(angular) {
    var caseModule = angular.module('case');
    caseModule.factory(
        'providerHttpFacade',
        [
            '$http',
            function($http) {
                var _getProviders = function() {
                    return $http.get('/providers');
                };

                return {
                    getProviders: _getProviders
                };
            }
        ]
    );
}(angular));