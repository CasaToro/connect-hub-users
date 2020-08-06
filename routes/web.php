<?php 
Route::group(['middleware' => ['web']], function () {
	Route::get('hub-users-info','Auth\AuthController@getUserInfoServices');
	Route::get('test-login','Test\TestController@showLoginForm');
	Route::post('login-client','Test\TestController@login');
	Route::post('data-user','Test\TestController@infoUserAuth');
	Route::post('data-profiles','Test\TestController@infoUserProfile');
	Route::get('home-hub','Test\TestController@home')->middleware('hub-users-auth');
});
