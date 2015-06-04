<?php

// Routes handled by angularjs
Route::get('/', 'IndexController@index');
Route::get('/cases/create', 'IndexController@index');
Route::get('/cases', 'IndexController@index');
Route::get('/categories/create', 'IndexController@index');
Route::get('/categories/edit/{id}', 'IndexController@index');
Route::get('/categories/{parent_id?}', 'IndexController@index');


// API routes
Route::group(['prefix' => 'api'], function() {
    Route::resource('categories', 'CategoryController', ['only' => ['index', 'show', 'store', 'update']]);
    Route::get('categories/check-existence/{parentId}/{category}/{exclude?}', 'CategoryController@check');


    Route::resource('cases', 'CaseController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    Route::get('cases/category/{id}', ['as' => 'cases.category', 'uses' => 'CaseController@index']);

    Route::resource('providers', 'ProviderController', ['only' => ['index']]);

    Route::get('slides/check-url-existence', 'SlideController@checkUrl');
});


