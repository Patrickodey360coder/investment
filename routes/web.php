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
	Route::get('/activities', 'ActivityController@index')->name('user.activities');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/profile', 'UserController@index')->name('profile');
	Route::post('/profile', 'UserController@update')->name('profile.update');

	Route::group(['prefix' => 'admin', 'middleware' => 'adminOnly'], function(){
		Route::post('/bonus/{id}', 'BonusController@addPayment')->name('admin.user.bonus');

		Route::get('/investors', 'UserController@showInvestors')->name('admin.investors');

		Route::post('/payments/{id}', 'PaymentController@addPayment')->name('admin.user.payments');

		Route::get('/premium', 'PremiumUserController@index')->name('admin.premium.users');
		Route::post('/premium', 'PremiumUserController@create')->name('admin.premium.users.create');

		Route::get('/trustway-investment', 'TrustwayInvestmentController@show')->name('admin.investments');
		Route::get('/trustway-investment/{id}/activate', 'TrustwayInvestmentController@activate')->name('admin.activate.investments');
		Route::post('/trustway-investment/{id}/activate', 'TrustwayInvestmentController@activateWithDate')->name('admin.activate.investments');

		Route::get('/withdrawals', 'WithdrawalController@show')->name('admin.withdrawals');
		Route::get('/withdrawals/{id}/accept', 'WithdrawalController@accept')->name('admin.accept.withdrawals');
		Route::get('/withdrawals/{id}/reject', 'WithdrawalController@reject')->name('admin.reject.withdrawals');
	});

	Route::group(['prefix' => 'dashboard/user', 'middleware' => 'premiumAndUserOnly'], function(){
		Route::get('/bank', 'BankAccountController@index')->name('user.bank');
		Route::post('/bank', 'BankAccountController@update')->name('user.bank.update');

		Route::get('/payments', 'PaymentController@index')->name('user.payments');
		
		Route::get('/withdrawals', 'WithdrawalController@index')->name('user.withdrawals');
		Route::post('/withdrawals', 'WithdrawalController@create')->name('user.withdrawals.create');
		Route::get('/withdrawals/delete/{id}', 'WithdrawalController@delete')->name('user.withdrawals.delete');
	});

	Route::group(['prefix' => 'dashboard', 'middleware' => 'userOnly'], function(){
		Route::get('/trustway-investment', 'TrustwayInvestmentController@index')->name('user.investments');
		Route::get('/trustway-investment/create', 'TrustwayInvestmentController@createForm')->name('user.create-trustway-investments');
		Route::post('/trustway-investment/create', 'TrustwayInvestmentController@store')->name('user.create-trustway-investments.store');
	});
});