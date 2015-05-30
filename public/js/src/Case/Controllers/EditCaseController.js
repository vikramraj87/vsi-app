(function(angular) {
    var caseModule = angular.module('case');
    caseModule.controller(
        'EditCaseController',
        [
            '$scope',
            'caseHttpFacade',
            'providerHttpFacade',
            function($scope, caseHttpFacade, providerHttpFacade) {
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

                $scope.case = new Case();
                $scope.case.slides.push(new Slide());

                $scope.providers = [];

                $scope.removeSlide = function() {
                    if($scope.case.slides.length > 1) {
                        $scope.case.slides.pop();
                    }
                };

                $scope.addSlide = function() {
                    $scope.case.slides.push(new Slide());
                };

                var providerResponsePromise = providerHttpFacade.getProviders();
                providerResponsePromise.then(function(response) {
                    $scope.providers = response.data;
                    $scope.case.virtualSlideProviderId = $scope.providers[0].id;
                }).catch(function(response) {

                }).finally(function() {

                });

                var responsePromise = caseHttpFacade.getCase(15);
                responsePromise.then(function(response) {
                    $scope.select(response.data.category.id);
                    $scope.case.virtualSlideProviderId = response.data.virtual_slide_provider_id;
                    $scope.case.clinicalData = response.data.clinical_data;
                    $scope.case.slides = [];
                    angular.forEach(response.data.slides, function(slideData) {
                        var slide = new Slide();
                        slide.stain = slideData.stain;
                        slide.url   = slideData.url;
                        $scope.case.slides.push(slide);
                    });
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
} (angular));