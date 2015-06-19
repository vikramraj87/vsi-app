describe("Slide HTTP Facade", function() {
    var facade,
        http;

    beforeEach(function() {
        module('case');
    });

    beforeEach(inject(function(_slideHttpFacade_, $httpBackend){
        facade = _slideHttpFacade_;
        http = $httpBackend;

        http.when('GET', '/api/slides/check-url-existence/0?url=http%3A%2F%2F129.11.191.7%2FResearch_4%2FTeaching%2FEducation%2FPostgraduate%2FCOW%2FCOW5%2F204049.svs')
            .respond({
                "status": "fail",
                "data": {
                    "reason": "SlideWithUrlExists",
                    "slide": {
                        "id": 24,
                        "stain": "HE",
                        "case_id": 25,
                        "url": "http:\/\/rosai.secondslide.com\/sem267\/sem267-case11.svs"
                    }
                }
            });

        http.when('GET', '/api/slides/check-url-existence/0?url=http%3A%2F%2Fgoogle.com')
            .respond({
                'status': 'success',
                'data': null
        });

        http.when('GET', '/api/slides/check-url-existence/24?url=http%3A%2F%2F129.11.191.7%2FResearch_4%2FTeaching%2FEducation%2FPostgraduate%2FCOW%2FCOW5%2F204049.svs')
            .respond({
                'status': 'success',
                'data': null
        });
    }));

    it("should call the correct url with correct query parameter", function(){
        var response = null;
        facade.checkExists('http://129.11.191.7/Research_4/Teaching/Education/Postgraduate/COW/COW5/204049.svs').then(function(exists) {
            response = exists;
        });
        http.flush();
        expect(response).toBeTruthy();

        facade.checkExists('http://google.com').then(function(exists) {
            response = exists;
        });
        http.flush();
        expect(response).toBeFalsy();
    });
});
