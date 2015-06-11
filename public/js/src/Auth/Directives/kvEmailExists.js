(function(angular){
    angular.module('auth')
        .directive('kvEmailExists', ['userHttpFacade', function(userHttpFacade) {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('exists', true);
                            return;
                        }
                        userHttpFacade.checkEmail(nVal).then(function(exists) {
                            ngModel.$setValidity('exists', exists);
                        }, function(error) {
                            ngModel.$setValidity('exists', false);
                        });
                    });
                }
            }
        }]);
}(angular));