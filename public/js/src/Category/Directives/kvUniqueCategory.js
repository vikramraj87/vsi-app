(function(angular){
    angular.module('category')
        .directive('kvUniqueCategory', ['categoryHttpFacade', function(categoryHttpFacade){
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, element, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(nVal.parent_id === 0 || nVal.category === "") {
                            ngModel.$setValidity('unique', true);
                            return;
                        }
                        ngModel.$setValidity('unique', false);
                        categoryHttpFacade.checkExists(nVal.parent_id, nVal.category, nVal.id).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function() {
                            ngModel.$setValidity('unique', true);
                        });
                    }, true);

                }
            }
        }]);
}(angular));