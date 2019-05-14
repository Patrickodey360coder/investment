<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/trustway-investment', 'TrustwayInvestmentController@index')->name('user.investments');
	Route::get('/trustway-investment/create', 'TrustwayInvestmentController@createForm')->name('user.create-trustway-investments');
	Route::post('/trustway-investment/create', 'TrustwayInvestmentController@store')->name('user.create-trustway-investments.store');
});