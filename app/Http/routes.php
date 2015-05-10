<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

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
 */
Route::get('categories/create', 'CategoryController@create');
Route::post('categories', 'CategoryController@store');

/*
 * Case resource routes
 */
Route::get('cases/create', 'CaseController@create');
Route::post('cases', 'CaseController@store');
