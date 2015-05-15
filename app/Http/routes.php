<?php

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('test', function() {
    $repo = new Kivi\Repositories\CategoryRepository();
    return $repo->hierarchicalCategoryIds(0);
});
// Search route
Route::get('search/{term}', 'SearchController@index');

/*
 * Category resource routes
 *
 */
Route::get('categories/{id}',                ['as' => 'category-show',    'uses' => 'CategoryController@show']);
Route::get('categories/{id}/edit/{edit_id}', ['as' => 'category-edit',    'uses' => 'CategoryController@show'])
    ->where('edit_id', '[0-9]+');
Route::get('categories',                     ['as' => 'category-index',   'uses' => 'CategoryController@show']);
Route::delete('categories/{id}',             ['as' => 'category-destroy', 'uses' =>'CategoryController@destroy']);
Route::post('categories',                    ['as' => 'category-store',   'uses' => 'CategoryController@store']);
Route::put('categories',                     ['as' => 'category-update',  'uses' => 'CategoryController@update']);


/*
 * Case resource routes
 */
Route::get('cases/category/{category_id}',  ['as' => 'case-category', 'uses' => 'CaseController@index'])
    ->where('category_id', '[0-9]+');
Route::get('cases/{id}',                    ['as' => 'case-show',     'uses' => 'CaseController@show']);
Route::get('cases',                         ['as' => 'case-index',    'uses' => 'CaseController@index']);
Route::post('cases',                        ['as' => 'case-store',    'uses' => 'CaseController@store']);
Route::put('cases',                         ['as' => 'case-update',   'uses' => 'CaseController@update']);
Route::delete('cases/{id}',                 ['as' => 'case-destroy',  'uses' => 'CaseController@destroy']);
