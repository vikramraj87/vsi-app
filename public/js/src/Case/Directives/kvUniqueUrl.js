(function(angular){
    angular.module('case')
        .directive('kvUniqueUrl', ['slideHttpFacade', function(slideHttpFacade){
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, element, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!ngModel || !nVal) {
                            ngModel.$setValidity('unique', true);
                            return;
                        }

                        // To prevent premature form submission while checking
                        ngModel.$setValidity('unique', false);

                        slideHttpFacade.checkExists(nVal).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function() {
                            ngModel.$setValidity('unique', true);
                        });
                    });
                }
            }
        }]);
}(angular));