<?php 
Route::group(['middleware' => ['web']], function () {
	Route::get('hub-users-info','Auth\AuthController@getUserInfoServices');
	Route::post('data-user','Test\TestController@infoUserAuth');
	Route::post('login-client','Test\TestController@login');
	Route::post('data-profiles','Test\TestController@infoUserProfile');
	Route::get('test-login','Test\TestController@showLoginFormTest')->name('test-login');
	Route::get('home-hub','Test\TestController@home')->middleware(['hub-users-auth','auth:'.config('hub-auth.guard-hub')]);
	Route::post('logout-test','Test\TestController@logout')
		   ->middleware(['hub-users-auth','auth:'.config('hub-auth.guard-hub')])
		   ->name('logout-test');
});