<?php

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Search route
Route::get('search/{term}', 'SearchController@index');

// Admin controller
Route::get('admin/new-category', 'AdminController@newCategory');

/*
 * Category resource routes
 *
 */
Route::get('categories/{id}', 'CategoryController@show');
Route::get('categories', 'CategoryController@show');
Route::get('categories/delete/{id}', 'CategoryController@destroy');
Route::post('categories', 'CategoryController@store');
Route::put('categories', 'CategoryController@update');


/*
 * Case resource routes
 */
Route::get('cases/create', 'CaseController@create');
Route::get('cases', 'CaseController@index');
Route::get('cases/{categoryId}', 'CaseController@index');
Route::post('cases', 'CaseController@store');
