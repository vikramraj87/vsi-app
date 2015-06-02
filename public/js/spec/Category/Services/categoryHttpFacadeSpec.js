describe('Category HTTP Facade', function() {
    var facade,
        http;

    beforeEach(function() {
        module('category');
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

        http.when('GET', '/api/categories/check-existence/6/Kaposi%20Sarcoma').respond({
            "status": "fail",
            "data": {
                "reason": "CategoryAlreadyExists",
                "category": {"id": 7, "category": "Kaposi Sarcoma", "parent_id": 6}
            }
        });

        http.when('GET', '/api/categories/check-existence/6/Kaposi%20Sarcom').respond(
            {"status": "success", "data": null}
        );

        http.when('POST', '/api/categories', 'parent_id=16&category=Kidney').respond({
            "status": "success",
            "data": {
                "parent_id": "16",
                "category": "Bladder",
                "updated_at": "2015-06-01 13:31:40",
                "created_at": "2015-06-01 13:31:40",
                "id": 17
            }
        });

        http.when('POST', '/api/categories', 'parent_id=16&category=Bladder').respond({
            "status":"fail",
            "data":{
                "reason": "ValidationFailed",
                "errors": [
                    "This combination of category, parent id already exists."
                ]
            }
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

    it('should call the appropriate uri when checking for existence of category', function() {
        var r;

        facade.checkExists(6, 'Kaposi Sarcoma').then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeTruthy();

        facade.checkExists(6, 'Kaposi Sarcom').then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeFalsy();
    });

    it('should call the appropriate api to save the category', function() {
        var savedCategory = null;

        facade.save({parent_id: 16, category: 'Kidney'}).then(function(saved) {
            savedCategory = saved;
        });
        http.flush();
        expect(savedCategory.id).toEqual(17);

        var failReason = "";
        facade.save({parent_id: 16, category: 'Bladder'}).then(function() {}, function(error) {
            failReason = error.reason;
        });
        http.flush();
        expect(failReason).toEqual('ValidationFailed');
    });
});