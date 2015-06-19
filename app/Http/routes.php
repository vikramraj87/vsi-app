<?php
// Routes handled by angularjs
Route::get('/', 'IndexController@index');

Route::get('/category/{category_id}/cases', 'IndexController@index');
Route::get('/category/{category_id}/categories', ['uses' => 'IndexController@index']);
Route::get('/category/{category_id}/edit/{child_id}', 'IndexController@index');
Route::get('/category/{category_id}/case/create', 'IndexController@index');
Route::get('/category/{category_id}/case/edit/{case_id}', 'IndexController@index');

Route::get('/login', 'IndexController@index');
//Route::get('/home', 'IndexController@index');
//Route::get('/cases/create', 'IndexController@index');
//Route::get('/cases/category/{category_id}', 'IndexController@index');
//Route::get('/categories/create', 'IndexController@index');
//Route::get('/categories/edit/{id}', 'IndexController@index');
//Route::get('/categories/{parent_id?}', 'IndexController@index');
//Route::get('/auth/register', 'IndexController@index');


// AJAX routes
Route::group(['prefix' => 'api'], function() {
    Route::resource('categories', 'CategoryController', ['only' => ['index', 'show', 'store', 'update']]);
    Route::get('categories/check-existence/{parentId}/{category}/{exclude?}', 'CategoryController@check');


    Route::resource('cases', 'CaseController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    Route::get('cases/category/{id}', ['as' => 'cases.category', 'uses' => 'CaseController@index']);

    Route::resource('providers', 'ProviderController', ['only' => ['index']]);

    Route::get('slides/check-url-existence/{exceptId}', 'SlideController@checkUrl');

    Route::get('users/check-email/{email}', 'UserController@checkEmail');

    Route::post('auth/login', 'Auth\AuthController@authenticate');
    Route::get('auth/user', 'Auth\AuthController@user');
    Route::get('auth/logout', 'Auth\AuthController@logout');
});


