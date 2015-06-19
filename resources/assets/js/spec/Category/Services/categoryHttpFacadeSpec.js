describe('Category HTTP Facade', function() {
    var facade,
        http,
        Api;

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

        http.when('GET', '/api/categories/2').respond({
            "status": "success",
            "data": {
                "id": 2,
                "category": "Hematopathology",
                "parent_id": null
            }
        });

        http.when('GET', '/api/categories/200').respond({
            "status": "fail",
            "data": {"reason": "CategoryNotFound", "id": 200}
        });

        http.when('GET', '/api/categories/check-existence/6/Kaposi%20Sarcoma/0').respond({
            "status": "fail",
            "data": {
                "reason": "CategoryAlreadyExists",
                "category": {"id": 7, "category": "Kaposi Sarcoma", "parent_id": 6}
            }
        });

        http.when('GET', '/api/categories/check-existence/6/Kaposi%20Sarcom/0').respond(
            {"status": "success", "data": null}
        );

        http.when('GET', '/api/categories/check-existence/6/Kaposi%20Sarcoma/7').respond(
            {"status": "success", "data": null}
        );

        http.when('POST', '/api/categories', 'parent_id=16&category=Kidney').respond({
            "status": "success",
            "data": {
                "parent_id": "16",
                "category": "Kidney",
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

        //http.when('POST', '/api/categories', 'parent_id=160&category=Urinary%20Bladder').respond({
        //    "status": "fail",
        //    "data": {"reason": "ValidationFailed", "errors": ["The selected parent id is invalid."]}
        //});


        http.when('PUT', '/api/categories/17', 'parent_id=16&category=Urinary+Bladder').respond({
            "status": "success",
            "data": {"id": 17, "category": "Urinary Bladder", "parent_id": 16, "updated_at": "2015-06-03 06:46:14"}
        });

        http.when('PUT', '/api/categories/17', 'parent_id=16&category=Kidney').respond({
            "status":"fail",
            "data":{
                "reason": "ValidationFailed",
                "errors": [
                    "This combination of category, parent id already exists."
                ]
            }
        });

        http.when('PUT', '/api/categories/200', 'parent_id=16&category=Kidney').respond({
            "status":"fail",
            "data":{
                "reason": "CategoryNotFound",
                'id': 200
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

    it('should process single category from the backend', function() {
        var category;
        facade.getById(2).then(function(c) {
            category = c;
        });
        http.flush();
        expect(category.id).toEqual(2);
        expect(category.parent_id).toBeNull();
        expect(category.category).toEqual('Hematopathology');

        var error;
        facade.getById(200).then(function(c) {}, function(e) {
            error = e;
        });
        http.flush();
        expect(error.reason).toEqual('CategoryNotFound');
        expect(error.id).toEqual(200);
    });

    it('should call the appropriate uri when checking for existence of category', function() {
        var r;

        facade.checkExists(6, 'Kaposi Sarcoma', 0).then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeTruthy();

        facade.checkExists(6, 'Kaposi Sarcom', 0).then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeFalsy();

        // Checking existence and also excluding
        facade.checkExists(6, 'Kaposi Sarcoma', 7).then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeFalsy();
    });

    it('should call the appropriate api to save or update the category', function() {
        // Create new category with valid data
        var savedCategory = null;
        facade.save({id:0, parent_id: 16, category: 'Kidney'}).then(function(saved) {
            savedCategory = saved;
        });
        http.flush();
        expect(savedCategory.id).toEqual(17);

        // Create new category with category name already existing
        var failReason = "";
        facade.save({id: 0, parent_id: 16, category: 'Bladder'}).then(function() {}, function(error) {
            failReason = error.reason;
        });
        http.flush();
        expect(failReason).toEqual('ValidationFailed');

        //Update already existing category with valid data
        var updatedCategory = null;
        facade.save({id: 17, parent_id: 16, category: 'Urinary Bladder'}).then(function(updated) {
            updatedCategory = updated;
        });
        http.flush();
        expect(updatedCategory.category).toEqual('Urinary Bladder');
        expect(updatedCategory.id).toEqual(17);
        expect(updatedCategory.parent_id).toEqual(16);
        expect(updatedCategory.updated_at).toEqual('2015-06-03 06:46:14');

        // Updated an existing category with the name of already exisitng category
        var error = null;
        facade.save({id: 17, parent_id: 16, category: 'Kidney'}).then(function() {}, function(e) {
            error = e;
        });
        http.flush();
        expect(error.reason).toEqual('ValidationFailed');

        // Updated a non existing category
        var error = null;
        facade.save({id: 200, parent_id: 16, category: 'Kidney'}).then(function() {}, function(e) {
            error = e;
        });
        http.flush();
        expect(error.reason).toEqual('CategoryNotFound');
        expect(error.id).toEqual(200);
    });
});