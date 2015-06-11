describe("User HTTP facade", function() {
    var facade,
        http;

    beforeEach(function() {
        module('auth');
    });

    beforeEach(inject(function(_userHttpFacade_, $httpBackend) {
        facade = _userHttpFacade_;
        http = $httpBackend;

        http.when('GET', '/api/users/check-email/dr.vikramraj87%40gmail.com').respond({
            "status": "fail", "data": {"reason": "EmailAlreadyExists"}
        });

        http.when('GET', '/api/users/check-email/johndoe%40gmail.com').respond({"status": "success", "data": null});
    }));



    it("should process api request and response for check email", function(){
        var exists = null;
        facade.checkEmail('dr.vikramraj87@gmail.com').then(function(e) {
            exists = e;
        });
        http.flush();
        expect(exists).toBeTruthy();

        exists = null;
        facade.checkEmail('johndoe@gmail.com').then(function(e) {
            exists = e;
        });
        http.flush();
        expect(exists).toBeFalsy();
    });
});