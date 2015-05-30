(function(angular){
    function Slide()
    {
        this.stain = "";
        this.url   = "";
    }

    function Case()
    {
        this.virtualSlideProviderId = 0;
        this.clinicalData           = "";
        this.categoryId             = 0;
        this.slides                 = [];
    }

    var caseModule = angular.module('case');

    caseModule.controller(
        'CreateCaseController',
        [
            '$scope',
            'providerHttpFacade',
            function($scope, providerHttpFacade) {
                $scope.providers = [];
                $scope.case = new Case();
                $scope.case.slides.push(new Slide());

                var responsePromise = providerHttpFacade.getProviders();
                responsePromise.then(function(response) {
                    $scope.providers = response.data;
                    $scope.case.virtualSlideProviderId = $scope.providers[0].id;
                }).catch(function(response) {

                }).finally(function() {

                });

                $scope.addSlide = function() {
                    $scope.case.slides.push(new Slide());
                };

                $scope.removeSlide = function() {
                    if($scope.case.slides.length > 1) {
                        $scope.case.slides.pop();
                    }
                };

                $scope.$watch(
                    function(scope) {
                        return scope.category
                    }, function(newValue, oldValue) {
                        $scope.case.categoryId = newValue !== null ? newValue.id : 0;
                    }
                )
            }
        ]
    );
}(angular));