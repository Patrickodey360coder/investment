<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function () {
	Route::post('login', 'API\UserController@login');
	Route::post('register', 'API\UserController@register');
	Route::post('/password/forgot', 'API\UserController@forgotPassword');

	Route::middleware('auth:api')->get('/user', function (Request $request) {
	    return $request->user();
	});

	Route::group(['middleware' => ['auth:api'], ], function () {
		Route::get('/activity', 'API\ActivityController@index');

		Route::get('/bank', 'API\BankAccountController@index');
		Route::post('/bank', 'API\BankAccountController@update');

		Route::get('/investments', 'API\TrustwayInvestmentController@index');

		Route::get('/logout', 'API\UserController@logout');

		Route::post('/password', 'API\UserController@changePassword');
		Route::post('/profile', 'API\UserController@update');

		Route::get('/withdrawals', 'API\WithdrawalController@index');
		Route::post('/withdrawals', 'API\WithdrawalController@create');
	});
});