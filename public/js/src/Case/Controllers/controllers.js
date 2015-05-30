(function(angluar) {
    function Slide() {
        this.stain = "";
        this.url   = "";
        this.id    = 0;
    }

    function Case() {
        this.id                     = 0;
        this.virtualSlideProviderId = 0;
        this.clinicalData           = "";
        this.categoryId             = 0;
        this.slides                 = [];
    }

    var caseModule = angular.module('case');

    caseModule.controller('editController', [
        '$scope', 'caseHttpFacade', 'providerHttpFacade', '$routeParams',
        function($scope, caseHttpFacade, providerHttpFacade, $routeParams) {

            $scope.case = new Case();
            $scope.case.slides.push(new Slide());
            $scope.action = 'Save';
            $scope.title = 'Create case';
            $scope.providers = [];

            var providerResponsePromise = providerHttpFacade.getProviders();
            providerResponsePromise.then(function(response) {
                $scope.providers = response.data;
                $scope.case.virtualSlideProviderId = $scope.providers[0].id;
            }).catch(function(response) {

            }).finally(function() {

            });


            if($routeParams.id !== undefined) {
                $scope.title = 'Edit case';
                $scope.action = 'Update';

                var responsePromise = caseHttpFacade.getCase($routeParams.id);
                responsePromise.then(function (response) {
                    // todo: Check for return of invalid response

                    var caseData = response.data;
                    $scope.select(caseData.category.id);
                    $scope.case.id = caseData.id;
                    $scope.case.virtualSlideProviderId = caseData.virtual_slide_provider_id;
                    $scope.case.clinicalData = caseData.clinical_data;
                    $scope.case.categoryId = caseData.category_id;
                    $scope.case.slides = [];
                    angular.forEach(caseData.slides, function (slideData) {
                        var slide = new Slide();
                        slide.stain = slideData.stain;
                        slide.url = slideData.url;
                        slide.id = slideData.id;
                        $scope.case.slides.push(slide);
                    });
                }).catch(function (response) {

                }).finally(function () {

                });
            }

            $scope.addSlide = function() {
                $scope.case.slides.push(new Slide());
            };

            $scope.removeSlide = function() {
                if($scope.case.slides.length > 1) {
                    $scope.case.slides.pop();
                }
            };

            $scope.submit = function() {
                var data = {
                    'category_id': $scope.case.categoryId,
                    'clinical_data': $scope.case.clinicalData,
                    'virtual_slide_provider_id': $scope.case.virtualSlideProviderId
                };

                data.stain = [];
                data.url   = [];
                angular.forEach($scope.case.slides, function(slide) {
                    data.stain.push(slide.stain);
                    data.url.push(slide.url);
                });

                var responsePromise = caseHttpFacade.saveCase(data);
                responsePromise.then(function(response) {
                    console.log(response.data);
                });
            };


            $scope.$watch(
                function(scope) {
                    return scope.category
                }, function(newValue, oldValue) {
                    $scope.case.categoryId = newValue !== null ? newValue.id : 0;
                }
            )

        }
    ]);

    caseModule.controller('listController', [
        '$scope', 'caseHttpFacade', '$routeParams',
        function($scope, caseHttpFacade, $routeParams) {
            $scope.cases = [];

            if($routeParams.id !== undefined) {
                categoryId = parseInt($routeParams.id);
                $scope.select(categoryId);
            }

            $scope.$watch(
                function(scope) {
                    return scope.category;
                }, function(newValue, oldValue) {
                    var categoryId = (newValue !== null) ? newValue.id : 0,
                        responsePromise = caseHttpFacade.getCases(categoryId);
                    $scope.cases = [];
                    responsePromise.then(function(response) {
                        if(response.data.status === 'success') {
                            $scope.cases = response.data.data;
                        }
                    }).catch(function(response) {

                    }).finally(function() {

                    });
                }
            );
        }
    ]);
} (angular));