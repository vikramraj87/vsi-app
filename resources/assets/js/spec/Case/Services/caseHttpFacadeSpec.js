describe('Case HTTP facade specification', function() {
    var facade, httpBackend;
    beforeEach(function() {
        module('case');
    });
    beforeEach(inject(function(_caseHttpFacade_, $httpBackend) {
        facade = _caseHttpFacade_;
        httpBackend = $httpBackend;

        httpBackend.when('GET', '/api/cases/category/7').respond(
            {
            'status': 'success',
            'data': [
                {
                    'id': 15,
                    'clinical_data':'Male 52 years. Lesion on arm',
                    'category_id':7,
                    'virtual_slide_provider_id':2,
                    'slides':
                        [
                            {
                                'id':5,
                                'case_id':15,
                                'url':'http:\/\/129.11.191.7\/Research_4\/Teaching\/Education\/Postgraduate\/COW\/COW5\/204049.svs',
                                'stain':'HE',
                                'remarks': null
                            },
                            {
                                'id':6,
                                'case_id':15,
                                'url':'http:\/\/129.11.191.7\/Research_4\/Teaching\/Education\/Postgraduate\/COW\/COW5\/204054.svs',
                                'stain':'HHV8',
                                'remarks': null
                            }
                        ],
                    'provider': {
                        'id': 2,
                        'name': 'University of Leeds',
                        'url': 'http:\/\/www.virtualpathology.leeds.ac.uk\/slidelibrary\/index.php'
                    },
                    'category':{
                        'id':7,
                        'category':'Kaposi Sarcoma'
                    }
                },
                {
                    'id':23,
                    'clinical_data':'Kaposi\'s sarcoma involving lymph nodes associated with suspected measles lymphadenopathy',
                    'category_id':7,
                    'virtual_slide_provider_id':1,
                    'slides':
                        [
                            {
                                'id':22,
                                'case_id':23,
                                'url':'http:\/\/rosai.secondslide.com\/sem1467\/sem1467-case16.svs\/',
                                'stain':'HE',
                                'remarks': null
                            }
                        ],
                    'provider':{
                        'id':1,
                        'name':'Rosai Collection',
                        'url':'http:\/\/www.rosaicollection.net\/'
                    },
                    'category':{
                        'id':7,
                        'category':'Kaposi Sarcoma'
                    }
                },
                {
                    'id':24,
                    'clinical_data':'Skin',
                    'category_id':7,
                    'virtual_slide_provider_id':1,
                    'slides':[
                        {
                            'id':23,
                            'case_id':24,
                            'url':'http:\/\/rosai.secondslide.com\/sem549\/sem549-case7.svs',
                            'stain':'HE',
                            'remarks': null
                        }
                    ],
                    'provider':{
                        'id':1,
                        'name':'Rosai Collection',
                        'url':'http:\/\/www.rosaicollection.net\/'
                    },
                    'category':{
                        'id':7,
                        'category':'Kaposi Sarcoma'
                    }
                }
            ]
        }
        );

        httpBackend.when('GET', '/api/cases/category/8').respond({
            'status': 'fail',
            'data': {
                'reason': 'CategoryNotFound',
                'id': 8
            }
        })

        httpBackend.when('GET', '/api/cases/15').respond({
            'status': 'success',
            'data': {
                'id':15,
                'clinical_data':'Male 52 years. Lesion on arm',
                'category_id':7,
                'virtual_slide_provider_id':2,
                'slides':[
                    {
                        'id':5,
                        'case_id':15,
                        'url':'http:\/\/129.11.191.7\/Research_4\/Teaching\/Education\/Postgraduate\/COW\/COW5\/204049.svs',
                        'stain':'HE',
                        'remarks': null
                    },
                    {
                        'id':6,
                        'case_id':15,
                        'url':'http:\/\/129.11.191.7\/Research_4\/Teaching\/Education\/Postgraduate\/COW\/COW5\/204054.svs',
                        'stain':'HHV8',
                        'remarks': null
                    }
                ],
                'provider':{
                    'id':2,
                    'name':'University of Leeds',
                    'url':'http:\/\/www.virtualpathology.leeds.ac.uk\/slidelibrary\/index.php'
                },
                'category':{
                    'id':7,
                    'category':'Kaposi Sarcoma'
                }
            }
        });

        httpBackend.when('GET', '/api/cases/100').respond({
            'status': 'fail',
            'data': {
                'reason': 'CaseNotFound',
                'id': 100
            }
        });

        httpBackend.when('POST', '/api/cases', 'clinical_data=Lesion+esophagus&virtual_slide_provider_id=2&category_id=7&url%5B%5D=http%3A%2F%2Fgoogle.com&url%5B%5D=http%3A%2F%2Fyahoo.com&stain%5B%5D=HE&stain%5B%5D=Giemsa&remarks%5B%5D=HE+of+kaposi+sarcoma+of+esophagus&remarks%5B%5D=Giemsa+of+kaposi+sarcoma+of+esophagus').respond({
            'status': 'success',
            'data': {
                'id': 101
            }
        })

        httpBackend.when('PUT', '/api/cases/102', 'clinical_data=Lesion+esophagus&virtual_slide_provider_id=2&category_id=7&url%5B%5D=http%3A%2F%2Fgoogle.com&url%5B%5D=http%3A%2F%2Fyahoo.com&stain%5B%5D=HE&stain%5B%5D=Giemsa&remarks%5B%5D=HE+of+kaposi+sarcoma+of+esophagus&remarks%5B%5D=Giemsa+of+kaposi+sarcoma+of+esophagus&slide_id%5B%5D=103&slide_id%5B%5D=104').respond({
            'status': 'success',
            'data': null
        })

        httpBackend.when('PUT', '/api/cases/103', 'clinical_data=Lesion+esophagus&virtual_slide_provider_id=2&category_id=7&url%5B%5D=http%3A%2F%2Fgoogle.com&url%5B%5D=http%3A%2F%2Fyahoo.com&stain%5B%5D=HE&stain%5B%5D=Giemsa&remarks%5B%5D=HE+of+kaposi+sarcoma+of+esophagus&remarks%5B%5D=Giemsa+of+kaposi+sarcoma+of+esophagus&slide_id%5B%5D=103&slide_id%5B%5D=104').respond({
            'status': 'fail',
            'data': {
                'reason': 'CaseNotFound',
                'id': 103
            }
        })

        httpBackend.when('DELETE', '/api/cases/102').respond({
            'status': 'success',
            'data': null
        });

        httpBackend.when('DELETE', '/api/cases/103').respond({
            'status': 'fail',
            'data': {
                'reason': 'CaseNotFound',
                'id': 103
            }
        });
    }));

    it('when getting cases, return cases data on success', function() {
        var casesPromise = facade.getCases(7);
        var casesData;
        casesPromise.then(function(data) {
            casesData = data;
        })
        httpBackend.flush();
        expect(casesData[0].id).toEqual(15);
        expect(casesData[1].slides[0].url).toEqual('http:\/\/rosai.secondslide.com\/sem1467\/sem1467-case16.svs\/');
        expect(casesData[2].category.id).toEqual(7);
    });

    it('when getting cases from non existing category, should return error data', function() {
        var casesPromise = facade.getCases(8);
        var errorData;
        casesPromise.then(function(data) {

        }, function(error) {
            errorData = error;
        })
        httpBackend.flush();
        expect(errorData.reason).toEqual('CategoryNotFound');
        expect(errorData.id).toEqual(8);
    });

    it('should return a single case when searched with id', function() {
        var casePromise = facade.getCase(15);
        var caseData;
        casePromise.then(function(data) {
            caseData = data;
        })
        httpBackend.flush();
        expect(caseData.id).toEqual(15);
        expect(caseData.category.id).toEqual(7);
    });

    it('should provide error data when non existing case is searched', function() {
        var error;
        facade.getCase(100).then(function(data) {
            // Don't worry about the success response
        },function(errorData) {
            error = errorData;
        });
        httpBackend.flush();
        expect(error.reason).toEqual('CaseNotFound');
        expect(error.id).toEqual(100);
    });

    it('should save a record and respond to feedback', function() {
        var feedback;
        var virtualCase = {};

        virtualCase.id = 0;
        virtualCase.clinicalData = 'Lesion esophagus';
        virtualCase.virtualSlideProviderId = 2;
        virtualCase.categoryId = 7;

        virtualCase.slides = [];
        virtualCase.slides.push({
            'url': 'http://google.com',
            'stain': 'HE',
            'remarks': 'HE of kaposi sarcoma of esophagus'
        });
        virtualCase.slides.push({
            'url': 'http://yahoo.com',
            'stain': 'Giemsa',
            'remarks': 'Giemsa of kaposi sarcoma of esophagus'
        })

        facade.save(virtualCase).then(function(data) {
            feedback = data;
        });
        httpBackend.flush();
        expect(feedback.id).toEqual(101);
    });

    it('should update a record when the virtual case has id property', function() {
        var virtualCase = {};
        var feedback;

        virtualCase.id = 102;
        virtualCase.clinicalData = 'Lesion esophagus';
        virtualCase.virtualSlideProviderId = 2;
        virtualCase.categoryId = 7;

        virtualCase.slides = [];
        virtualCase.slides.push({
            'id': 103,
            'url': 'http://google.com',
            'stain': 'HE',
            'remarks': 'HE of kaposi sarcoma of esophagus'

        });
        virtualCase.slides.push({
            'id': 104,
            'url': 'http://yahoo.com',
            'stain': 'Giemsa',
            'remarks': 'Giemsa of kaposi sarcoma of esophagus'
        })

        facade.save(virtualCase).then(function(data) {
            feedback = data;
        });
        httpBackend.flush();
        expect(feedback).toBeNull();
    });

    it('should provide appropriate feedback when updating non-existing case', function() {
        var virtualCase = {};
        var feedback;

        virtualCase.id = 103;
        virtualCase.clinicalData = 'Lesion esophagus';
        virtualCase.virtualSlideProviderId = 2;
        virtualCase.categoryId = 7;

        virtualCase.slides = [];
        virtualCase.slides.push({
            'id': 103,
            'url': 'http://google.com',
            'stain': 'HE',
            'remarks': 'HE of kaposi sarcoma of esophagus'
        });
        virtualCase.slides.push({
            'id': 104,
            'url': 'http://yahoo.com',
            'stain': 'Giemsa',
            'remarks': 'Giemsa of kaposi sarcoma of esophagus'
        })

        facade.save(virtualCase).then(function(data) {

        }, function(error) {
            feedback = error;
        });
        httpBackend.flush();
        expect(feedback.reason).toEqual('CaseNotFound');
        expect(feedback.id).toEqual(103);
    });

    it('should delete a record and provide a feedback', function() {
        var feedback;
        facade.delete(102).then(function(data) {
            feedback = data;
        })
        httpBackend.flush();
        expect(feedback).toBeNull();
    });

    it('should provide appropriate feedback for error response', function() {
        var feedback;
        facade.delete(103).then(function(data) {

        }, function(error) {
            feedback = error;
        });
        httpBackend.flush();
        expect(feedback.reason).toEqual('CaseNotFound');
        expect(feedback.id).toEqual(103);
    });
});