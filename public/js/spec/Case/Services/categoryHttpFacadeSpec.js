describe('Category HTTP Facade', function() {
    var facade,
        http;

    beforeEach(function() {
        module('case');
    });

    beforeEach(inject(function(_categoryHttpFacade_, $httpBackend) {
        facade = _categoryHttpFacade_;
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



    it('should fetch all categories from the backend', function() {
        var categories;
        facade.getAll().then(function(data){
            categories = data;
        });
        http.flush();
        expect(categories.length).toEqual(13);
        expect(categories[0].category).toEqual('Histopathology');
        expect(categories[12].parent_id).toEqual(10);
    });
});