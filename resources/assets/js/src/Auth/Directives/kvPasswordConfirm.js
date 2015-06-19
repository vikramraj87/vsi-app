(function(angular){
    angular.module('auth')
        .directive('kvPasswordConfirm', function() {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('confirm', true);
                            return;
                        }

                        ngModel.$setValidity('confirm', nVal.first === nVal.confirm);
                    }, true);
                }
            }
        });
}(angular));
