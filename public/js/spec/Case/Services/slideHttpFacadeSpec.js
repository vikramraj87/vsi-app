describe("Slide HTTP Facade", function() {
    var facade,
        http;

    beforeEach(function() {
        module('case');
    });

    beforeEach(inject(function(_slideHttpFacade_, $httpBackend){
        facade = _slideHttpFacade_;
        http = $httpBackend;

        http.when('GET', '/api/slides/checkURL?url=http%3A%2F%2F129.11.191.7%2FResearch_4%2FTeaching%2FEducation%2FPostgraduate%2FCOW%2FCOW5%2F204049.svs')
            .respond({
                'status': 'fail',
                'data': {
                    'reason': 'UrlAlreadyExists'
                }
            });
        http.when('GET', '/api/slides/checkURL?url=http%3A%2F%2Fgoogle.com')
            .respond({
                'status': 'success',
                'data': null
            });
    }));

    it("should call the correct url with correct query parameter", function(){
        var r = null;
        facade.check('http://129.11.191.7/Research_4/Teaching/Education/Postgraduate/COW/COW5/204049.svs').then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeFalsy();

        facade.check('http://google.com').then(function(response) {
            r = response;
        });
        http.flush();
        expect(r).toBeTruthy();
    });
});
