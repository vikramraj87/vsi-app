<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kiv! Slidebox</title>

    <link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<base href="/">
</head>
<body ng-controller="AppController">
	<nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Kiv!</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a ui-sref="start">Home</a></li>
                <li><a ui-sref="category.category-list({id: 0})" ng-show="checkAccess('category.category-list')">Categories</a></li>
                <li><a ui-sref="category.case-list({id: 0})">Cases</a></li>
                {{--<li><a href="#">Favourites</a></li>--}}
                {{--<li><a href="#">Collections</a></li>--}}
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li ng-if="checkAccess('login')"><a ui-sref="login">Login</a></li>
                {{--<li ng-if="checkAccess("><a href="/auth/register">Register</a></li>--}}

                <li class="dropdown" ng-if="user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span ng-bind="user.name"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a ng-click="logout()">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
	<!-- End of navigation -->
    <div ui-view></div>

	<!-- Scripts -->
	<script src="/js/vendor.js"></script>
	<script src="/js/src/app.js"></script>
	<script src="/js/src/Auth/Services/authHttpFacade.js"></script>
    <script src="/js/src/AppController.js"></script>
	<script src="/js/src/filters.js"></script>

    <script src="/js/src/Auth/Services/userHttpFacade.js"></script>
    <script src="/js/src/Auth/Services/authHttpFacade.js"></script>
    <script src="/js/src/Auth/Services/sessionFactory.js"></script>
    <script src="/js/src/Auth/Services/authService.js"></script>


    <script src="/js/src/Auth/Directives/kvPasswordConfirm.js"></script>
    <script src="/js/src/Auth/Directives/kvUniqueEmail.js"></script>
    <script src="/js/src/Auth/Directives/kvEmailExists.js"></script>

    <script src="/js/src/Auth/Controllers/loginController.js"></script>

    <script src="/js/src/Category/Services/categoryHttpFacade.js"></script>
    <script src="/js/src/Category/Services/categoryService.js"></script>

    <script src="/js/src/Category/Controllers/categoryController.js"></script>
    <script src="/js/src/Category/Controllers/listController.js"></script>
    <script src="/js/src/Category/Controllers/editController.js"></script>

    <script src="/js/src/Category/Directives/kvUniqueCategory.js"></script>
    <script src="/js/src/Category/Directives/kvBreadcrumbs.js"></script>
    <script src="/js/src/Category/Directives/kvSubcategories.js"></script>

    <script src="/js/src/Case/Services/caseHttpFacade.js"></script>
    <script src="/js/src/Case/Services/providerHttpFacade.js"></script>
    <script src="/js/src/Case/Services/slideHttpFacade.js"></script>

    <script src="/js/src/Case/Directives/kvUniqueUrl.js"></script>

    <script src="/js/src/Case/Controllers/listController.js"></script>
    <script src="/js/src/Case/Controllers/editController.js"></script>
</body>
</html>
