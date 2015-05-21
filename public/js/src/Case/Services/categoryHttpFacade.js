(function(angular) {
    var caseModule = angular.module('case');
    caseModule.factory(
        'categoryHttpFacade',
        [
            '$http',
            function($http) {
                var _getALlCategories = function() {
                    return $http.get('/cats');
                };

                return {
                    getAllCategories: _getALlCategories
                }
            }
        ]
    );
}(angular));
