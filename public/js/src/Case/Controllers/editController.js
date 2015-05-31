(function(angular){
    function Slide()
    {
        this.id = 0;
        this.url = "";
        this.stain = "";
    }

    function Case()
    {
        this.clinicalData = "";
        this.virtualSlideProviderId = 0;
        this.categoryId = 0;
        this.slides = [];
    }

    angular.module('case')
        .controller('CaseEditController', ['$scope', 'caseHttpFacade', 'providerHttpFacade', function($scope, caseHttpFacade, providerHttpFacade) {
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

            $scope.$watch(
                function(scope) {
                    return scope.category
                }, function(newValue, oldValue) {
                    $scope.case.categoryId = newValue !== null ? newValue.id : 0;
                }
            )

            $scope.save = function() {
                caseHttpFacade.save($scope.case);

                $scope.case = new Case();
                $scope.case.slides.push(new Slide());
                $scope.case.virtualSlideProviderId = $scope.providers[0].id;
            }

            providerHttpFacade.getAll().then(function(data) {
                $scope.providers = data;
                $scope.case.virtualSlideProviderId = $scope.providers[0].id;
            });
        }]);
}(angular));