(function(angular){
    angular.module('case')
        .controller('CaseEditController', [
            '$scope', 'digitalCase', 'providers', 'caseHttpFacade', '$state', '$stateParams',
            function($scope, digitalCase, providers, caseHttpFacade, $state, $stateParams) {
                $scope.case = digitalCase;
                $scope.providers = providers;

                $scope.save = function(digitalCase) {
                    if($scope.editCaseForm.$invalid) {
                        return;
                    }
                    caseHttpFacade.save(digitalCase).then(function(response) {
                        if($state.current.name === 'category.case-create') {
                            $scope.case = new Case();
                            $scope.case.virtualSlideProviderId = providers[0].id;
                            $scope.case.categoryId = parseInt($stateParams.id, 10);
                            $scope.case.slides.push(new Slide());

                            $scope.editCaseForm.$setPristine();
                            return;
                        }
                        $state.go('category.case-list', {id: digitalCase.categoryId});
                        return;
                    }, function(error) {
                        console.log(error);
                    });
                };

                $scope.removeSlide = function() {
                    if($scope.case.slides.length > 1) {
                        $scope.case.slides.pop();
                    }
                };

                $scope.addSlide = function() {
                    $scope.case.slides.push(new Slide());
                };
            }
        ]);
}(angular));