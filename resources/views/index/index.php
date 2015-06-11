<!DOCTYPE html>
<html lang="en" ng-app="app">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slidebox</title>

    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <base href="/">
</head>

<body>

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
            <li><a href="<?php url('/') ?>">Home</a></li>
        </ul>
    </div>
</nav>
<!-- End of navigation -->



<div id="page-content" ng-controller="CategoryController">
    <div class="container" ng-show="flash">
        <div class="alert alert-success" ng-bind="flash"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li>
                        <a ng-click="select(0)">Categories</a>
                    </li>
                    <li ng-repeat="parent in parents">
                        <a ng-bind="parent.category" ng-click="select(parent.id)"></a>
                    </li>
                    <li ng-show="category">
                        <span ng-bind="category.category"></span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row" ng-view></div>
    </div>
</div>
<!-- End of Page content -->

<script src="/js/vendor.js"></script>

<script src="/js/src/app.js"></script>

<script src="/js/src/filters.js"></script>

<script src="/js/src/Category/Services/categoryHttpFacade.js"></script>
<script src="/js/src/Category/Services/categoryService.js"></script>

<script src="/js/src/Category/Controllers/categoryController.js"></script>
<script src="/js/src/Category/Controllers/listController.js"></script>
<script src="/js/src/Category/Controllers/editController.js"></script>

<script src="/js/src/Category/Directives/kvUniqueCategory.js"></script>

<script src="/js/src/Case/Services/caseHttpFacade.js"></script>
<script src="/js/src/Case/Services/providerHttpFacade.js"></script>
<script src="/js/src/Case/Services/slideHttpFacade.js"></script>

<script src="/js/src/Case/Directives/kvUniqueUrl.js"></script>

<script src="/js/src/Case/Controllers/listController.js"></script>
<script src="/js/src/Case/Controllers/editController.js"></script>
</body>
</html>
