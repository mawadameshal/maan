<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});
 */


Route::get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/search', 'HomeController@search');
Route::get('showUsreData/{id}', 'ShowFormController@show');  // to get all info about the user and his request
Route::resource('response', 'ResponseController');   // post request to store a replay with attachment

Route::get('/suggestions/{id}', 'HomeController@suggestions');  // get  the suggestions of the form (complaint ..)
Route::get('/categories/{id}', 'HomeController@categories');  // get  the categories of the form (complaint ..)
Route::get('/sent_types', 'HomeController@sent_types');  

Route::get('/citizen-search/{id_number}', 'HomeController@citizen_search');

Route::post('/form', 'HomeController@store_form');
Route::get('/evaluate/{id}', 'EvaluateController@index');


Route::put('/citizen/update-mobile/{id}', 'HomeController@update_mobile');
Route::get('/getInfo','GetInfoController@index');

Route::group([
	'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::get('forms','FormsController@index');
Route::get('forms/{id}','FormsController@show');

Route::post('citizen','CreateCitizenController@store');
Route::post('message','MessagesController@store');

