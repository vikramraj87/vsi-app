@extends('app')

@section('content')
<div ng-controller="CategoryController">
    <ol class="breadcrumb">
        <li><a href="#" ng-click="select(0)">Categories</a></li>
        <li ng-repeat="category in parents"><a href="#" ng-click="select(category.id)" ng-bind="category.category"></a></li>
    </ol>
    <div class="row">
        <div class="col-md-3">
            <ul class="nav">
                <li ng-repeat="category in children"><a ng-bind="category.category" href="#" ng-click="select(category.id)"></a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <pre><% category %></pre>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/src/Case/Services/categoryHttpFacade.js') }}"></script>
<script src="{{ asset('js/src/Case/Services/categoryService.js') }}"></script>
<script src="{{ asset('js/src/Case/Controllers/CategoryController.js') }}"></script>
@endsection