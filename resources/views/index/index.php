<!DOCTYPE html>
<html lang="en" ng-app="app">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VSI</title>

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

        <div class="row">
            <div class="col-md-3" ng-show="children.length">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Sub-categories <span class="badge pull-right">{{ children.length }}</span></h3></div>
                <ul class="nav nav-pills nav-stacked">
                    <li ng-repeat="child in children">
                        <a ng-click="select(child.id)">{{ child.category }}<span class="pull-right"><span class="glyphicon glyphicon-triangle-right"></span></span></a>
                    </li>
                </ul>
                </div>
            </div>
            <div ng-view ng-class="children.length ? 'col-md-9' : 'col-md-12'">
            </div>
        </div>
    </div>
</div>
<!-- End of Page content -->

<script src="/js/vendor.js"></script>

<script src="/js/src/app.js"></script>

<script src="/js/src/Category/Services/categoryHttpFacade.js"></script>

<script src="/js/src/Category/Controllers/categoryController.js"></script>
<script src="/js/src/Category/Controllers/createController.js"></script>

<script src="/js/src/Case/Services/caseHttpFacade.js"></script>
<script src="/js/src/Case/Services/providerHttpFacade.js"></script>
<script src="/js/src/Case/Services/slideHttpFacade.js"></script>

<script src="/js/src/Case/Directives/kvUnique.js"></script>

<script src="/js/src/Case/Controllers/listController.js"></script>
<script src="/js/src/Case/Controllers/editController.js"></script>
</body>
</html>
