describe('Category Controller', function() {
	var $controller,
		facade,
		service,
		$rootScope;

	beforeEach(module('category'));

	beforeEach(function() {
		module(function($provide) {
			
			$provide.factory('categoryService', function() {
				return {
					isLoaded: jasmine.createSpy('isLoaded').and.callFake(function() {
						return true; // comes from the test block
					}),
					findSubcategories: jasmine.createSpy('findSubcategories').and.callFake(function(parentId) {
						parentId = parseInt(parentId, 10);

						if(0 !== parentId) {
							return [];
						}
						return [{
		                    "id": 1,
		                    "category": "Histopathology",
		                    "parent_id": null
		                }, {
		                    "id": 2,
		                    "category": "Hematopathology",
		                    "parent_id": null
		                }, {
		                    "id": 9,
		                    "category": "Cytopathology",
		                    "parent_id": null
		                }];
					})
				};
			});

			$provide.factory('categoryHttpFacade', function($q){
				return {
					getAll: jasmine.createSpy('getAll').and.callFake(function() {
						return $q.when([
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
			                }
						]);
					})
				};
			});
		})
	});

	beforeEach(inject(function(_$controller_, categoryService, categoryHttpFacade, _$rootScope_) {
		$controller = _$controller_;
		service = categoryService;
		facade = categoryHttpFacade;
		$rootScope = _$rootScope_;
	}));

	describe('Initialization', function() {
		var controller,
			scope;

		beforeEach(function() {
			scope = $rootScope.$new();
			controller = $controller('CategoryController', {
				$scope: scope,
				$stateParams: {
					id: 0
				},
				$state: {

				}
			});
		});

		it('should be initialized correctly', function() {
			expect(scope.parents.length).toBe(0);
			expect(scope.children.length).toBe(3);
			expect(scope.category).toBeNull();
		});
	});


	describe('Ensure mock working properly', function() {
		it('with category service already loaded', function() {
			expect(service.isLoaded()).toBeTruthy();
		});

		it('mocked facade should return data', function() {
			var categories;
			facade.getAll().then(function(cats) {
				categories = cats;
			});
			$rootScope.$digest();
			expect(categories.length).toEqual(13);
	        expect(categories[0].category).toEqual('Histopathology');
	        expect(categories[12].parent_id).toEqual(10);
		});
	});
});
