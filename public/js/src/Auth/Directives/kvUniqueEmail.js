(function(angular){
    angular.module('auth')
        .directive('kvUniqueEmail', ['userHttpFacade', function(userHttpFacade) {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('unique', true);
                            return;
                        }
                        userHttpFacade.checkEmail(nVal).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function(error) {
                            ngModel.$setValidity('unique', true);
                        });
                    });
                }
            }
        }]);
}(angular));