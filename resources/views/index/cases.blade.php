@extends('app')

@section('title', 'Digital cases - Slidebox')

@section('content')
<div id="page-content" ng-controller="CategoryController">
    <div class="container" ng-show="flash">
        <div class="alert alert-success" ng-bind="flash"></div>
    </div>
    <div class="container">
        <div class="row" ng-view></div>
    </div>
</div>
<!-- End of Page content -->
@endsection

@section('scripts')
<script src="/js/src/filters.js"></script>

<script src="/js/src/Auth/Services/userHttpFacade.js"></script>

<script src="/js/src/Auth/Directives/kvPasswordConfirm.js"></script>
<script src="/js/src/Auth/Directives/kvUniqueEmail.js"></script>
<script src="/js/src/Auth/Directives/kvEmailExists.js"></script>

<script src="/js/src/Auth/Controllers/registerController.js"></script>

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
@endsection
