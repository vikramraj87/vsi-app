describe('Category Service Specification', function() {
    var service;

    var data = [{"id": 11, "category": "Angiosarcoma", "parent_id": 10}, {
        "id": 4,
        "category": "Blood vessels",
        "parent_id": 1
    }, {"id": 33, "category": "Bone", "parent_id": 26}, {
        "id": 26,
        "category": "Bone and joints",
        "parent_id": 1
    }, {"id": 23, "category": "Breast", "parent_id": 1}, {"id": 28, "category": "Breast", "parent_id": 9}, {
        "id": 25,
        "category": "Central nervous system",
        "parent_id": 1
    }, {"id": 9, "category": "Cytopathology", "parent_id": null}, {
        "id": 38,
        "category": "Degenerative disorders",
        "parent_id": 25
    }, {"id": 15, "category": "Epithelioid hemangioendothelioma", "parent_id": 10}, {
        "id": 22,
        "category": "Female reproductive system",
        "parent_id": 1
    }, {"id": 31, "category": "Fibrocystic disease of breast", "parent_id": 23}, {
        "id": 19,
        "category": "Gastrointestinal tract",
        "parent_id": 1
    }, {"id": 43, "category": "Head and neck", "parent_id": 1}, {
        "id": 2,
        "category": "Hematopathology",
        "parent_id": null
    }, {"id": 1, "category": "Histopathology", "parent_id": null}, {
        "id": 39,
        "category": "Infections",
        "parent_id": 25
    }, {"id": 6, "category": "Intermediate Malignancy", "parent_id": 5}, {
        "id": 34,
        "category": "Joints",
        "parent_id": 26
    }, {"id": 7, "category": "Kaposi Sarcoma", "parent_id": 6}, {
        "id": 37,
        "category": "Kidney",
        "parent_id": 16
    }, {"id": 42, "category": "Liver and biliary tree", "parent_id": 1}, {
        "id": 21,
        "category": "Male reproductive system",
        "parent_id": 1
    }, {"id": 10, "category": "Malignant vascular tumors", "parent_id": 5}, {
        "id": 20,
        "category": "Mediastinum",
        "parent_id": 1
    }, {"id": 5, "category": "Neoplasms", "parent_id": 4}, {
        "id": 27,
        "category": "Neoplasms",
        "parent_id": 13
    }, {"id": 30, "category": "Neoplasms", "parent_id": 23}, {
        "id": 32,
        "category": "Neoplasms",
        "parent_id": 25
    }, {"id": 29, "category": "Neoplasms", "parent_id": 28}, {
        "id": 35,
        "category": "Neoplasms",
        "parent_id": 33
    }, {"id": 44, "category": "Neoplasms", "parent_id": 42}, {
        "id": 14,
        "category": "Platelet disorders",
        "parent_id": 2
    }, {"id": 12, "category": "Red cell disorders", "parent_id": 2}, {
        "id": 18,
        "category": "Respiratory tract",
        "parent_id": 1
    }, {"id": 40, "category": "Skin", "parent_id": 1}, {
        "id": 24,
        "category": "Soft tissues",
        "parent_id": 1
    }, {"id": 41, "category": "Soft tissues", "parent_id": 9}, {
        "id": 17,
        "category": "Urinary Bladder",
        "parent_id": 16
    }, {"id": 16, "category": "Urinary tract", "parent_id": 1}, {
        "id": 13,
        "category": "White blood cell disorders",
        "parent_id": 2
    }];

    beforeEach(function() {
        module('category');
    });

    beforeEach(inject(function(_categoryService_) {
        service = _categoryService_;
        service.init(data);
    }));

    it('should indicate that the categories are loaded', function() {
        expect(service.isLoaded()).toBeTruthy();
    });

    it("should find category by id", function(){
        var category = service.findById(40);
        expect(category.id).toEqual(40);
        expect(category.category).toEqual('Skin');
        expect(category.parent_id).toEqual(1);

        var category = service.findById('16');
        expect(category.id).toEqual(16);
        expect(category.category).toEqual('Urinary tract');
        expect(category.parent_id).toEqual(1);
    });

    it("should find subcategories by category id", function(){
        var subcategories = service.findSubcategories(16);

        expect(subcategories.length).toEqual(2);

        expect(subcategories[0].id).toEqual(37);
        expect(subcategories[0].category).toEqual('Kidney');
        expect(subcategories[0].parent_id).toEqual(16);

        expect(subcategories[1].id).toEqual(17);
        expect(subcategories[1].category).toEqual('Urinary Bladder');
        expect(subcategories[1].parent_id).toEqual(16);

        var subcategories = service.findSubcategories(0);
        expect(subcategories.length).toEqual(3);
    });

    it("should return all ancestors of the selected category", function() {
        var parents = service.findParents(7);
        expect(parents.length).toEqual(4);

        expect(parents[0].id).toEqual(1);

        expect(parents[1].id).toEqual(4);
        expect(parents[1].category).toEqual('Blood vessels');

        expect(parents[2].category).toEqual('Neoplasms');
        expect(parents[2].parent_id).toEqual(4);

        expect(parents[3].id).toEqual(6);
        expect(parents[3].category).toEqual('Intermediate Malignancy');
    });
});
