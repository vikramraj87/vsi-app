(function(angular){
    angular.module('category')
        .controller('CategoryEditController', [
            '$scope', '$rootScope', 'categoryHttpFacade', 'selected', '$stateParams',
            function($scope, $rootScope, categoryHttpFacade, selected, $stateParams) {
                $scope.selected = selected;
                $scope.originalParentId = $stateParams.id;

                $scope.save = function(category) {
                    if($scope.editCategoryForm.$valid) {
                        categoryHttpFacade.save(category).then(function(savedCategory) {
                            $rootScope.$broadcast('CategoryEdited', {editedCategory: savedCategory});
                        });
                    }
                };
            }
        ]);
}(angular));