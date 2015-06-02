(function(angular){
    angular.module('case')
        .directive('kvUniqueUrl', ['slideHttpFacade', function(slideHttpFacade){
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, element, attrs, ngModel) {
                    element.bind('blur', function(e) {
                        if(!ngModel || !element.val()) return;
                        var currentValue = element.val();
                        slideHttpFacade.check(currentValue).then(function(response) {
                            if(currentValue === element.val()) {
                                ngModel.$setValidity('unique', response);
                            }
                        }, function() {
                            ngModel.$setValidity('unique', true);
                        });
                    });
                }
            }
        }]);
}(angular));