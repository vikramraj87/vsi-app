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
angular.module('auth', []);