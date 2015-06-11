describe("Auth HTTP facade specification", function() {
    var facade,
        http;

    beforeEach(function() {
        module('auth')
    });

    beforeEach(inject(function(_authHttpFacade_, $httpBackend) {
        facade = _authHttpFacade_;
        http = $httpBackend;

        http.when('GET', '/api/auth/user').respond({
            "status": "success",
            "data": {
                "id": 51,
                "name": "Vikram Raj",
                "email": "dr.vikramraj87@gmail.com",
                "role_id": 1,
                "created_at": "2015-06-06 06:52:02",
                "updated_at": "2015-06-06 11:32:37",
                "role": {"id": 1, "role": "User"}
            }
        });

        http.when('POST', '/api/auth/login', 'email=dr.vikramraj87%40gmail.com&password=12345678').respond({
            "status": "fail",
            "data": {"reason": "InvalidCredentials"}
        });

        http.when('POST', '/api/auth/login', 'email=dr.vikramraj87&password=1').respond({
            "status": "fail",
            "data": {"reason": "ValidationFailed", "errors": ["The email must be a valid email address."]}
        });

        http.when('POST', '/api/auth/login', 'email=dr.vikramraj87%40gmail.com&password=K1rth1k%40s1n1').respond({
            "status": "success",
            "data": {
                "id": 51,
                "name": "Vikram Raj",
                "email": "dr.vikramraj87@gmail.com",
                "role_id": 1,
                "created_at": "2015-06-06 06:52:02",
                "updated_at": "2015-06-07 01:49:33",
                "role": {"id": 1, "role": "User"}
            }
        });

        http.when('GET', '/api/auth/logout').respond({'status': 'success', 'data': null});

        //http.expect('GET', '/api/auth/user').respond({"status": "fail", "data": {"reason": "Guest"}});
    }));

    it("should fetch user if logged in", function(){
        var user;
        facade.fetchUser().then(function(u) {
            user = u;
        });
        http.flush();
        expect(user.id).toEqual(51);
        expect(user.role.role).toEqual('User');

        //var error;
        //facade.fetchUser().then(function(u) {}, function(e) {
        //    error = e;
        //});
        //http.flush();
        //expect(error.reason).toEqual('Guest');
    });

    it('should provide invalid credentials login feedback', function() {
        var reason;
        facade.loginUser('dr.vikramraj87@gmail.com', '12345678').then(function(u) {}, function(e) {
            reason = e.reason;
        });
        http.flush();
        expect(reason).toEqual('InvalidCredentials');
    });

    it('should provide validation failed feedback', function() {
        var reason;
        facade.loginUser('dr.vikramraj87', '1').then(function(u) {}, function(e) {
            reason = e.reason;
        });
        http.flush();
        expect(reason).toEqual('ValidationFailed');
    });

    it('should provide user if login credentials are valid', function() {
        var user;
        facade.loginUser('dr.vikramraj87@gmail.com', 'K1rth1k@s1n1').then(function(u) {
            user = u;
        });
        http.flush();
        expect(user.email).toEqual('dr.vikramraj87@gmail.com');
        expect(user.role.role).toEqual('User');
        expect(user.name).toEqual('Vikram Raj');
    });

    it("should handle response from server after successful logout", function(){
        var data;
        facade.logoutUser().then(function(d) {
            data = d;
        });
        http.flush();
        expect(data).toBeNull();
    });
});
