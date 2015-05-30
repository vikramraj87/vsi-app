describe('Category controller specification', function() {
    var $scope,
        categoryFacade,
        http;

    beforeEach(function() {
        module('case');
    });

    beforeEach(inject(function($controller, $rootScope, $httpBackend, _categoryHttpFacade_) {
        $scope = $rootScope.$new();
        $controller('CategoryController', {
            $scope: $scope
        });
        categoryFacade = _categoryHttpFacade_;
        http = $httpBackend;

        http.when('GET', '/api/categories').respond({
            "status": "success",
            "data": [
                {
                    "id": 1,
                    "category": "Histopathology",
                    "parent_id": null
                }, {
                    "id": 2,
                    "category": "Hematopathology",
                    "parent_id": null
                }, {
                    "id": 4,
                    "category": "Blood vessels",
                    "parent_id": 1
                }, {
                    "id": 5,
                    "category": "Neoplasms",
                    "parent_id": 4
                }, {
                    "id": 6,
                    "category": "Intermediate Malignancy",
                    "parent_id": 5
                }, {
                    "id": 7,
                    "category": "Kaposi Sarcoma",
                    "parent_id": 6
                }, {
                    "id": 9,
                    "category": "Cytopathology",
                    "parent_id": null
                }, {
                    "id": 10,
                    "category": "Malignant vascular tumors",
                    "parent_id": 5
                }, {
                    "id": 11,
                    "category": "Angiosarcoma",
                    "parent_id": 10
                }, {
                    "id": 12,
                    "category": "Red cell disorders",
                    "parent_id": 2
                }, {
                    "id": 13,
                    "category": "White blood cell disorders",
                    "parent_id": 2
                }, {
                    "id": 14,
                    "category": "Platelet disorders",
                    "parent_id": 2
                }, {
                    "id": 15,
                    "category": "Epithelioid hemangioendothelioma",
                    "parent_id": 10
                }]
        });
    }));

    it("initializes categories", function(){
        expect($scope.parents.length).toBe(0);
        expect($scope.category).toBeNull();
        expect($scope.children.length).toBe(0);

        http.flush();

        expect($scope.parents.length).toBe(0);
        expect($scope.category).toBeNull();
        expect($scope.children.length).toBe(3);
        expect($scope.children[0].category).toBe('Histopathology');
    });

    it("selects categories and loads the appropriate slides", function(){
        http.flush();
        $scope.select(6);

        expect($scope.parents.length).toEqual(3);
        expect($scope.parents[0].category).toEqual('Histopathology');
        expect($scope.parents[1].category).toEqual('Blood vessels');
        expect($scope.parents[2].category).toEqual('Neoplasms');

        expect($scope.category.category).toEqual('Intermediate Malignancy');

        expect($scope.children.length).toEqual(1);
        expect($scope.children[0].category).toEqual('Kaposi Sarcoma');
    });
});
