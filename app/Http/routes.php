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

Route::get('leeds/{term}', function($term) {
    $leeds = new \Kivi\Providers\Leeds();
    return $leeds->search($term);
});

Route::get('rosai/{term}', function($term) {
    $rosai = new \Kivi\Providers\RosaiCollection();
    $links = $rosai->search($term);
    $arrLinks = [];
    foreach($links as $link) {
        $arrLinks[] = $link->toArray();
    }
    return $arrLinks;
});

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
