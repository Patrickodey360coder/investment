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
    return view('index')->with('activeLink','index');
})->name('index');

Route::get('/blog/maximize-investment', function () {
    return view('blog.maximize-investment')->with('activeLink','');
})->name('blog-1');

Route::get('/blog/financial-freedom', function () {
    return view('blog.financial-freedom')->with('activeLink','');
})->name('blog-2');

Route::get('/disclaimer', function () {
    return view('disclaimer')->with('activeLink','');
})->name('disclaimer');

Route::get('/privacy', function () {
    return view('privacy')->with('activeLink','');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms')->with('activeLink','');
})->name('terms');

Route::get('/about-us', function () {
    return view('about-us')->with('activeLink','about-us');
})->name('about-us');

Route::get('/services', function () {
    return view('services')->with('activeLink','services');
})->name('services');

Route::get('/investment', function () {
    return view('investment')->with('activeLink','investment');
})->name('investment');

Route::get('/investmentpage', function () {
    return view('investmentpage')->with('activeLink','');
})->name('investmentpage');

Route::get('/loans', function () {
    return view('loans')->with('activeLink','');
})->name('loans');

Route::get('/retirement', function () {
    return view('retirement')->with('activeLink','');
})->name('retirement');

Route::get('/forgot/password', function () {
    return view('auth.forgot-password')->with('activeLink','');
})->name('forgotPassword');

Route::post('/forgot/password', 'UserController@forgotPassword')->name('resetPassword');


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
		Route::post('/premium/topup/{id}', 'PremiumUserController@addPayment')->name('admin.premium.topup');

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