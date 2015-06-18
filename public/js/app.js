function Category()
{
    this.id = 0;
    this.category = "";
    this.parent_id = 0;
}

function Slide()
{
    this.id = 0;
    this.url = "";
    this.stain = "";
    this.remarks = "";
}

function Case()
{
    this.id = 0;
    this.clinicalData = "";
    this.virtualSlideProviderId = 0;
    this.categoryId = 0;
    this.slides = [];
}


angular.module('app', ['case', 'category', 'auth', 'ui.router'])
    .config(function($stateProvider, $urlRouterProvider, $locationProvider) {
        $urlRouterProvider.otherwise('/');

        $stateProvider
            .state('start', {
                url: '/',
                templateUrl: 'partials/start.html',
                data: {
                    access: ['Guest', 'User', 'Mod', 'Admin']
                }
            })
            .state('category', {
                url: '/category/:id',
                templateUrl: 'partials/case/categories.html',
                abstract: true,
                controller: 'CategoryController'
            })
            .state('category.case-list', {
                url: '/cases',
                templateUrl: 'partials/case/list.html',
                controller: 'CaseListController',
                resolve: {
                    cases: ['caseHttpFacade', '$stateParams', function(caseHttpFacade, $stateParams) {
                        return caseHttpFacade.getCases($stateParams.id);
                    }]
                },
                data: {
                    access: ['Guest', 'User', 'Mod', 'Admin']
                }
            })
            .state('category.category-list', {
                url:'/categories',
                templateUrl: 'partials/category/list.html',
                controller: 'CategoryListController',
                data: {
                    access: ['Mod', 'Admin']
                }
            })
            .state('category.category-edit', {
                url: '/edit/:categoryId',
                templateUrl: 'partials/category/edit.html',
                controller: 'CategoryEditController',
                resolve: {
                    selected: ['categoryHttpFacade', '$stateParams', function(categoryHttpFacade, $stateParams) {
                        return categoryHttpFacade.getById($stateParams.categoryId).then(function(category) {
                            category.parent_id = parseInt($stateParams.id, 10);
                            return category;
                        })
                    }]
                },
                data: {
                    access: ['Mod', 'Admin']
                }
            })
            .state('category.case-create', {
                url: '/case/create',
                templateUrl: 'partials/case/create.html',
                controller: 'CaseEditController',
                resolve: {
                    providers: ['providerHttpFacade', function(providerHttpFacade) {
                        return providerHttpFacade.getAll();
                    }],
                    digitalCase: ['providers', '$stateParams', function(providers, $stateParams) {
                        var c = new Case();
                        c.virtualSlideProviderId = providers[0].id;
                        c.categoryId = parseInt($stateParams.id, 10);
                        c.slides.push(new Slide());
                        return c;
                    }]
                },
                data: {
                    access: ['Mod', 'Admin']
                }
            })
            .state('category.case-edit', {
                url: '/case/edit/:caseId',
                templateUrl: 'partials/case/edit.html',
                controller: 'CaseEditController',
                resolve: {
                    providers: ['providerHttpFacade', function(providerHttpFacade) {
                        return providerHttpFacade.getAll();
                    }],
                    digitalCase: ['providers', '$stateParams', 'caseHttpFacade', function(providers, $stateParams, caseHttpFacade) {
                        return caseHttpFacade.getCase($stateParams.caseId).then(function(digitalCase) {
                            var tmp = new Case();
                            tmp.id = digitalCase.id;
                            tmp.clinicalData = digitalCase.clinical_data;
                            tmp.virtualSlideProviderId = digitalCase.provider.id;
                            tmp.categoryId = parseInt($stateParams.id, 10);
                            angular.forEach(digitalCase.slides, function(slide) {
                                var s = new Slide();
                                s.id = slide.id;
                                s.remarks = slide.remarks;
                                s.stain = slide.stain;
                                s.url = slide.url;
                                tmp.slides.push(s);
                            });
                            return tmp;
                        });
                    }]
                },
                data: {
                    access: ['Mod', 'Admin']
                }

            })
            .state('login', {
                url: '/login',
                templateUrl: 'partials/auth/login.html',
                controller: 'AuthLoginController',
                data: {
                    access: ['Guest']
                }
            });

        $locationProvider.html5Mode(true);
    });
angular.module('case', []);
angular.module('category', []);
angular.module('auth', []);;
(function(angular){
    angular.module('app')
        .controller('AppController', [
            '$scope', '$rootScope', '$state', 'authHttpFacade', 'sessionFactory',
            function($scope, $rootScope, $state, authHttpFacade, sessionFactory) {
                $scope.user = null;

                $rootScope.$on('$stateChangeStart', function(event, toState, toParams) {
                    if(! _checkAccess(toState)) {
                        event.preventDefault();
                        $state.go('start');
                    }
                });

                $rootScope.$on('UserLoggedOut', function() {
                    if(! _checkAccess($state.current)) {
                        $state.go('start');
                    }
                });

                $scope.$on('UserFetched', function() {
                    if($state.current.name && ! _checkAccess($state.current)) {
                        $state.go('start');
                    }
                    $scope.user = sessionFactory.user();
                });

                var _checkAccess = function(state) {
                    if(typeof state === 'string') {
                        if(null === $state.get(state)) {
                            throw new Error('The state "' + state + '" does not exists');
                        }
                        state = $state.get(state);
                    }
                    var user = sessionFactory.user(),
                        role = null === user ? 'Guest' : user.role.role,
                        access = state.data.access;
                    return access.indexOf(role) !== -1;
                };

                $scope.checkAccess = _checkAccess;

                var _logout = function() {
                    var user = sessionFactory.user();
                    if(null !== user) {
                        authHttpFacade.logoutUser().then(function(response) {
                            sessionFactory.setUser(null);
                            $scope.user = null;
                            $rootScope.$broadcast('UserLoggedOut');
                        });
                    }
                };

                $scope.logout = _logout;

                var _init = function() {
                    authHttpFacade.fetchUser().then(function(user) {
                        sessionFactory.setUser(user);
                        $scope.user = user;
                        $rootScope.$broadcast('UserFetched');
                    });
                };

                _init();
            }
        ]);
}(angular));
;
(function(angular){
    angular.module('app')
        .filter('exceptWithId', function() {
            return function(input, id) {
                var output = [];
                id = parseInt(id, 10);
                angular.forEach(input, function(item) {
                    if(id != item.id) {
                        output.push(item);
                    }
                });
                return output;
            }
        });
}(angular));;
(function(angular){
    angular.module('auth')
        .factory('authHttpFacade', ['$http', '$q', function($http, $q) {
            var AUTH_USER   = '/api/auth/user',
                LOGIN_USER  = '/api/auth/login',
                LOGOUT_USER = '/api/auth/logout';

            var _success = function(response) {
                if(response.status !== 200) {
                    return $q.reject(response);
                }
                if(typeof response.data !== 'object') {
                    return $q.reject(response.data);
                }
                if(response.data.status === 'fail') {
                    return $q.reject(response.data.data);
                }
                return response.data.data;
            };

            var _fetchAuthenticatedUser = function() {
                return $http.get(AUTH_USER).then(_success);
            };

            var _loginUser = function(email, password) {
                return $http({
                    method: 'POST',
                    url: LOGIN_USER,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param({
                        email: email,
                        password: password
                    })
                }).then(_success);
            };

            var _logoutUser = function() {
                return $http.get(LOGOUT_USER).then(_success);
            };

            return {
                fetchUser: _fetchAuthenticatedUser,
                loginUser: _loginUser,
                logoutUser: _logoutUser
            };
        }]);
}(angular));
;
(function(angular){
    angular.module('auth')
        .factory('authService', ['authHttpFacade', 'sessionFactory', function(authHttpFacade, sessionFactory) {
            var rules = [];

            return {

            };
        }]);
}(angular));
;
(function(angular){
    angular.module('auth')
        .factory('sessionFactory', function() {
            var _user = null;

            var _setUser = function(user) {
                _user = user;
            };

            var _getUser = function() {
                return _user;
            };

            return {
                setUser: _setUser,
                user: _getUser
            };
        });
}(angular));
;
(function(angular){
    angular.module('auth')
        .factory('userHttpFacade', ['$http', '$q', function($http) {
            var CHECK = '/api/users/check-email/:email';

            var _checkEmail = function(email) {
                return $http.get(CHECK.replace(':email', encodeURIComponent(email))).then(function(response) {
                    if(response.status !== 200) {
                        $q.reject(response.data);
                    }
                    if(typeof response.data !== 'object') {
                        $q.reject(response.data);
                    }
                    if(response.data.status === 'fail') {
                        return true;
                    }
                    return false;
                });
            }

            return {
                checkEmail: _checkEmail
            };
    }]);
}(angular));
;
(function(angular){
    angular.module('auth')
        .directive('kvEmailExists', ['userHttpFacade', function(userHttpFacade) {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('exists', true);
                            return;
                        }
                        userHttpFacade.checkEmail(nVal).then(function(exists) {
                            ngModel.$setValidity('exists', exists);
                        }, function(error) {
                            ngModel.$setValidity('exists', false);
                        });
                    });
                }
            }
        }]);
}(angular));;
(function(angular){
    angular.module('auth')
        .directive('kvPasswordConfirm', function() {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('confirm', true);
                            return;
                        }

                        ngModel.$setValidity('confirm', nVal.first === nVal.confirm);
                    }, true);
                }
            }
        });
}(angular));
;
(function(angular){
    angular.module('auth')
        .directive('kvUniqueEmail', ['userHttpFacade', function(userHttpFacade) {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, elem, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!nVal) {
                            ngModel.$setValidity('unique', true);
                            return;
                        }
                        userHttpFacade.checkEmail(nVal).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function(error) {
                            ngModel.$setValidity('unique', true);
                        });
                    });
                }
            }
        }]);
}(angular));;
(function(angular){
    angular.module('auth')
        .controller('AuthLoginController', [
            '$scope', '$rootScope', 'authHttpFacade', 'sessionFactory', 'authService',
            function($scope, $rootScope, authHttpFacade, sessionFactory, authService) {
                $scope.credentials = null;
                $scope.invalidCredentials = false;

                $scope.login = function(credentials) {
                    if($scope.loginForm.$invalid) {
                        return;
                    }
                    authHttpFacade.loginUser(credentials.email, credentials.password).then(function(user) {
                        sessionFactory.setUser(user);
                        $rootScope.$broadcast('UserFetched');
                    }, function(error) {
                        if(error.reason === 'InvalidCredentials') {
                            $scope.invalidCredentials = true;
                            $scope.credentials.password = "";
                        }
                    });
                }
            }
        ]);
}(angular));
;
(function(angular, $) {
    angular.module('category')
        .factory('categoryHttpFacade', ['$http', '$q', function($http, $q) {
            var INDEX  = '/api/categories',
                SHOW   = '/api/categories/:categoryId',
                CHECK  = '/api/categories/check-existence/:parentId/:category/:excludeId',
                STORE  = '/api/categories',
                UPDATE = '/api/categories/:categoryId';

            var _processSuccessResponse = function(response) {
                if(response.status === 200 && typeof response.data === 'object' && response.data.status === 'success') {
                    return response.data.data;
                }
                if(response.data.status === 'fail') {
                    return $q.reject(response.data.data);
                }
            };

            var _processErrorResponse = function(response) {
                return $q.reject(response.data.data)
            }

            var _getAll = function() {
                return $http.get(INDEX)
                    .then(_processSuccessResponse, _processErrorResponse);
            };

            var _getById = function(categoryId) {
                return $http.get(SHOW.replace(':categoryId', categoryId))
                    .then(_processSuccessResponse, _processErrorResponse);
            }

            var _checkExists = function(parentId, category, excludeId) {
                parentId = parseInt(parentId, 10);

               if(isNaN(excludeId)) {
                   excludeId = 0;
               }

                var url = CHECK.replace(':parentId', parentId);
                url = url.replace(':category', encodeURIComponent(category));
                url = url.replace(':excludeId', excludeId);

                return $http.get(url)
                    .then(function(response) {
                        if(response.status !== 200) {
                            $q.reject(response.data);
                        }
                        if(typeof response.data !== 'object') {
                            $q.reject(response.data);
                        }
                        if(response.data.status === 'fail') {
                            return true;
                        }
                        return false;
                    })
            };

            var _createCategory = function(category) {
                delete category.id;
                return $http({
                    method: 'POST',
                    url: STORE,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(category)
                }).then(_processSuccessResponse, _processErrorResponse);
            };

            var _updateCategory = function(category) {
                var id = category.id;
                delete category.id;

                return $http({
                    method: 'PUT',
                    url: UPDATE.replace(':categoryId', id),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(category)
                }).then(_processSuccessResponse, _processErrorResponse);
            };

            var _save = function(category) {
                if(!category.id) {
                    return _createCategory(category);
                }
                return _updateCategory(category);
            };

            return {
                getAll: _getAll,
                checkExists: _checkExists,
                save: _save,
                getById: _getById
            };
        }]);
}(angular, window.jQuery));
;
(function(angular){
    angular.module('category')
        .factory('categoryService', ['$filter', function($filter) {
            var _categories;

            var _loaded = false;

            var _init = function(categories) {
                _categories = categories;
                _loaded = true;
            }

            var _isLoaded = function() {
                return _loaded;
            }

            var _findById = function(categoryId) {
                categoryId = parseInt(categoryId);
                return $filter('filter')(_categories, {id: categoryId}, true)[0];
            }

            var _findSubcategories = function(categoryId) {
                categoryId = parseInt(categoryId);
                if(0 === categoryId) {
                    categoryId = null;
                }
                return $filter('filter')(_categories, {parent_id: categoryId}, true);
            }

            var _findParents = function(categoryId) {
                var parents = [],
                    parent  = _findById(categoryId);

                while(parent.parent_id !== null) {
                    parent = _findById(parent.parent_id);
                    parents.unshift(parent);
                }

                return parents;
            }

            var _addCategory = function(category) {
                _categories.push(category);
            };

            var _replaceCategory = function(newCategory) {
                var oldCategoryId = parseInt(newCategory.id);
                _categories = $filter('filter')(_categories, function(category, index) {return category.id != oldCategoryId});
                _categories.push(newCategory);
            }

            return {
                init: _init,
                isLoaded: _isLoaded,
                findById: _findById,
                findSubcategories: _findSubcategories,
                findParents: _findParents,
                addCategory: _addCategory,
                replaceCategory: _replaceCategory
            };
        }]);
}(angular));;
(function(angular){
    angular.module('category')
        .directive('kvBreadcrumbs', function() {
            var _controller = ['$scope', '$state', function($scope, $state) {
                var _getUrl = function(categoryId) {
                    var params = $scope.params ? $scope.$eval($scope.params) : {};
                    params.id = categoryId;
                    return $state.href($state.current, params);
                };
                $scope.getUrl = _getUrl;
            }];

            return {
                scope: {
                    'ancestors': '=',
                    'category': '=',
                    'params': '@'
                },
                restrict: 'E',
                templateUrl: 'partials/category/_breadcrumbs.html',
                controller: _controller
            };
        });
}(angular));
;
(function(angular){
    angular.module('category')
        .directive('kvSubcategories', function() {
            var FILTER_AFTER = 6;

            var _controller = ['$scope', '$state', function($scope, $state) {
                $scope.except = $scope.except ? parseInt($scope.except, 10) : 0;
                $scope.filterAfter = $scope.filterAfter ? parseInt($scope.filterAfter, 10) : FILTER_AFTER;

                var _getUrl = function(categoryId) {
                    var params = $scope.params ? $scope.$eval($scope.params) : {};
                    params.id = categoryId;
                    return $state.href($state.current, params);
                }
                $scope.getUrl = _getUrl;
            }];

            return {
                scope: {
                    'subcategories': '=',
                    'except': '@',
                    'filterAfter': '@',
                    'params': '@'
                },
                restrict: 'E',
                templateUrl: 'partials/category/_subcategories.html',
                controller: _controller
            };
        });
}(angular));
;
(function(angular){
    angular.module('category')
        .directive('kvUniqueCategory', ['categoryHttpFacade', function(categoryHttpFacade){
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, element, attrs, ngModel) {
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(nVal.parent_id === 0 || nVal.category === "") {
                            ngModel.$setValidity('unique', true);
                            return;
                        }
                        ngModel.$setValidity('unique', false);
                        categoryHttpFacade.checkExists(nVal.parent_id, nVal.category, nVal.id).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function() {
                            ngModel.$setValidity('unique', true);
                        });
                    }, true);

                }
            }
        }]);
}(angular));;
(function(angular){
    angular.module('category')
        .controller('CategoryController', [
            '$scope', 'categoryHttpFacade', 'categoryService', '$filter', '$timeout', '$stateParams', '$state',
            function($scope, categoryHttpFacade, categoryService, $filter, $timeout, $stateParams, $state) {

                // Initial state of the scope
                $scope.parents = [];
                $scope.category = null;
                $scope.children = [];

                // Scope function to change the selected category
                var _select = function(categoryId) {
                    categoryId = parseInt(categoryId, 10);
                    $scope.children = categoryService.findSubcategories(categoryId);

                    if(categoryId === 0) {
                        $scope.parents = [];
                        $scope.category = null;
                        return;
                    }

                    $scope.category = categoryService.findById(categoryId);
                    $scope.parents = categoryService.findParents(categoryId);
                }

                var _flashMsg = function(message) {
                    $scope.flash = message;
                    $timeout(function() {
                        $scope.flash = "";
                    }, 5000);
                }

                var _addCategory = function(category) {
                    categoryService.addCategory(category);
                    $scope.children = categoryService.findSubcategories(category.parent_id);
                };

                $scope.$on('CategoryAdded', function(event, args) {
                    _addCategory(args.addedCategory);
                });

                var _replaceCategory = function(newCategory) {
                    categoryService.replaceCategory(newCategory);
                    $scope.children = categoryService.findSubcategories(newCategory.parent_id);
                }

                $scope.$on('CategoryEdited', function(event, args) {
                    _replaceCategory(args.editedCategory);
                    $state.go('category.category-list', {id: args.editedCategory.parent_id});
                });

                var _init = function() {
                    if(!categoryService.isLoaded()) {
                        categoryHttpFacade.getAll().then(function(categories) {
                            categoryService.init(categories);
                            _select($stateParams.id);
                            $scope.$broadcast('CategoriesLoaded');
                        });
                        return;
                    }
                    _select($stateParams.id);
                };

                _init();
            }
        ]);
}(angular));;
(function(angular){
    angular.module('category')
        .controller('CategoryEditController', [
            '$scope', '$rootScope', 'categoryHttpFacade', 'selected', '$stateParams',
            function($scope, $rootScope, categoryHttpFacade, selected, $stateParams) {
                $scope.selected = selected;
                $scope.originalParentId = $stateParams.id;

                $scope.save = function(category) {
                    if($scope.editCategoryForm.$valid) {
                        categoryHttpFacade.save(category).then(function(savedCategory) {
                            $rootScope.$broadcast('CategoryEdited', {editedCategory: savedCategory});
                        });
                    }
                };
            }
        ]);
}(angular));;
(function(angular){
    angular.module('category')
        .controller('CategoryListController', [
            '$scope', '$rootScope', 'categoryHttpFacade',
            function($scope, $rootScope, categoryHttpFacade) {
                $scope.save = function(category) {
                    if($scope.createCategoryForm.$valid) {
                        categoryHttpFacade.save(category).then(function(savedCategory) {
                            $rootScope.$broadcast('CategoryAdded', {addedCategory: savedCategory});
                            _init();
                        });
                    }
                };

                var _init = function() {
                    $scope.cat = new Category();
                    $scope.cat.parent_id = $scope.category !== null ? $scope.category.id : 0;
                    if($scope.createCategoryForm) {
                        $scope.createCategoryForm.$setPristine();
                    }
                };
                _init();
            }
        ]
    );
}(angular));;
(function(angular, $) {
    var caseModule = angular.module('case');
    caseModule.factory(
        'caseHttpFacade',
        [
            '$http',
            '$q',
            function($http, $q) {
                var INDEX   = '/api/cases/category/:categoryId',
                    SHOW    = '/api/cases/:caseId',
                    STORE   = '/api/cases',
                    UPDATE  = '/api/cases/:caseId',
                    DESTROY = '/api/cases/:caseId';

                var _processSuccessResponse = function(response) {
                    if(response.status === 200 && typeof response.data === 'object' && response.data.status === 'success') {
                        return response.data.data;
                    }
                    if(response.data.status === 'fail') {
                        return $q.reject(response.data.data);
                    }
                };

                var _processErrorResponse = function(response) {
                    return $q.reject(response.data.data)
                }

                var _getCases = function(categoryId) {
                    categoryId = parseInt(categoryId, 10);
                    return $http.get(INDEX.replace(':categoryId', categoryId), {cache: true})
                        .then(_processSuccessResponse, _processErrorResponse);
                };

                //todo: while retrieving slides id should be retrieved
                var _getCase = function(caseId) {
                    caseId = parseInt(caseId, 10);
                    return $http.get(SHOW.replace(':caseId', caseId))
                        .then(_processSuccessResponse, _processErrorResponse);
                };

                var _save = function(virtualCase) {
                    var data = {
                        'clinical_data': virtualCase.clinicalData,
                        'virtual_slide_provider_id': virtualCase.virtualSlideProviderId,
                        'category_id': virtualCase.categoryId,
                        'url': [],
                        'stain': [],
                        'remarks': []
                    };

                    angular.forEach(virtualCase.slides, function(slide) {
                        data.url.push(slide.url);
                        data.stain.push(slide.stain);
                        data.remarks.push(slide.remarks);
                    });

                    if(virtualCase.id === 0) {
                        return _saveCase(data);
                    }

                    data.slide_id = [];
                    angular.forEach(virtualCase.slides, function(slide) {
                        data.slide_id.push(slide.id);
                    });

                    return _updateCase(virtualCase.id, data);
                };

                var _saveCase = function(data) {
                    var postData = $.param(data);
                    return $http({
                        method: 'POST',
                        url: STORE,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: postData
                    }).then(_processSuccessResponse, _processErrorResponse);
                };

                // todo: While updating slides id should also be passed
                var _updateCase = function(id, data) {
                    var postData = $.param(data);
                    var id = parseInt(id, 10);

                    return $http({
                        method: 'PUT',
                        url: UPDATE.replace(':caseId', id.toString()),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: postData
                    }).then(_processSuccessResponse, _processErrorResponse);
                };

                var _delete = function(id) {
                    return $http.delete(DESTROY.replace(':caseId', id.toString()))
                        .then(_processSuccessResponse, _processErrorResponse);
                }

                return {
                    getCases: _getCases,
                    getCase: _getCase,
                    save: _save,
                    delete: _delete
                };
            }
        ]
    );
}(angular, window.jQuery));;
(function(angular) {
    angular.module('case')
        .factory('providerHttpFacade', ['$http', '$q', function($http, $q) {

            var _processSuccessResponse = function(response) {
                if(response.status === 200 && typeof response.data === 'object' && response.data.status === 'success') {
                    return response.data.data;
                }
                if(response.data.status === 'fail') {
                    return $q.reject(response.data.data);
                }
            };

            var _processErrorResponse = function(response) {
                return $q.reject(response.data.data)
            }

            var _getAll = function() {
                return $http.get('/api/providers', {cache: true}).then(_processSuccessResponse, _processErrorResponse)
            };

            return {
                getAll: _getAll
            };
        }]);
}(angular));;
(function(angular){
    angular.module('case')
        .factory('slideHttpFacade', ['$http', '$q', function($http, $q) {
            var _checkExists = function(url, exceptId) {
                if(exceptId === undefined) {
                    exceptId = 0;
                }
                exceptId = parseInt(exceptId, 10);
                return $http.get('/api/slides/check-url-existence/' + exceptId + '?url=' + encodeURIComponent(url))
                    .then(function(response) {
                        if(response.status !== 200) {
                            $q.reject(response.data);
                        }
                        if(typeof response.data !== 'object') {
                            $q.reject(response.data);
                        }

                        if(response.data.status === 'fail') {
                            return true;
                        }
                        return false;
                    }, function(response) {
                        $q.reject(response.data);
                    });
            }

            return {
                checkExists: _checkExists
            };
        }]);
}(angular));;
(function(angular){
    angular.module('case')
        .directive('kvUniqueUrl', ['slideHttpFacade', function(slideHttpFacade){
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function(scope, element, attrs, ngModel) {
                    var exceptId = scope.$eval(attrs.kvUniqueUrl);
                    exceptId = exceptId === undefined ? 0 : parseInt(exceptId, 10);
                    scope.$watch(attrs.ngModel, function(nVal) {
                        if(!ngModel || !nVal) {
                            ngModel.$setValidity('unique', true);
                            return;
                        }

                        // To prevent premature form submission while checking
                        ngModel.$setValidity('unique', false);

                        slideHttpFacade.checkExists(nVal, exceptId).then(function(exists) {
                            ngModel.$setValidity('unique', !exists);
                        }, function() {
                            ngModel.$setValidity('unique', true);
                        });
                    });
                }
            }
        }]);
}(angular));;
(function(angular){
    angular.module('case')
        .controller('CaseEditController', [
            '$scope', 'digitalCase', 'providers', 'caseHttpFacade', '$state', '$stateParams',
            function($scope, digitalCase, providers, caseHttpFacade, $state, $stateParams) {
                $scope.case = digitalCase;
                $scope.providers = providers;

                $scope.save = function(digitalCase) {
                    if($scope.editCaseForm.$invalid) {
                        return;
                    }
                    caseHttpFacade.save(digitalCase).then(function(response) {
                        if($state.current.name === 'category.case-create') {
                            $scope.case = new Case();
                            $scope.case.virtualSlideProviderId = providers[0].id;
                            $scope.case.categoryId = parseInt($stateParams.id, 10);
                            $scope.case.slides.push(new Slide());

                            $scope.editCaseForm.$setPristine();
                            return;
                        }
                        $state.go('category.case-list', {id: digitalCase.categoryId});
                        return;
                    }, function(error) {
                        console.log(error);
                    });
                };

                $scope.removeSlide = function() {
                    if($scope.case.slides.length > 1) {
                        $scope.case.slides.pop();
                    }
                };

                $scope.addSlide = function() {
                    $scope.case.slides.push(new Slide());
                };
            }
        ]);
}(angular));;
(function(angular){
    angular.module('case')
        .controller('CaseListController', [
            '$scope', 'cases',
            function($scope, cases)
            {
                $scope.cases = cases;
            }
        ]
    );
}(angular));