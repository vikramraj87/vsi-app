<?php

Route::get('/', 'IndexController@index');
Route::get('/cases', 'IndexController@index');
Route::get('/cases/create', 'IndexController@index');

Route::group(['prefix' => 'api'], function() {
    Route::resource('categories', 'CategoryController', ['only' => ['index', 'show', 'store', 'update']]);

    Route::resource('cases', 'CaseController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    Route::get('cases/category/{id}', ['as' => 'cases.category', 'uses' => 'CaseController@index']);

    Route::resource('providers', 'ProviderController', ['only' => ['index']]);
});

