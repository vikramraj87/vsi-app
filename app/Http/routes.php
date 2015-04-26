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
    $cases = $leeds->search($term);
    return toArray($cases);
});

Route::get('rosai/{term}', function($term) {
    $rosai = new \Kivi\Providers\RosaiCollection();
    $cases = $rosai->search($term);
    return toArray($cases);
});



Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Search route



/**
 * @param $cases
 * @return array
 */
function toArray($cases)
{
    $arr = [];
    foreach ($cases as $case) {
        /** @var \Kivi\Entity\VirtualCase $case */

        $tmp = ["data" => $case->getData()];
        foreach ($case->getLinks() as $link) {
            $tmp["links"][] = $link->toArray();
        }
        $arr[] = $tmp;
    }
    return $arr;
}