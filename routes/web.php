<?php 
Route::group(['middleware' => ['web']], function () {
	Route::get('login-form', 'AuthClientController@showLoginForm');
	Route::post('login-client', 'AuthClientController@loginClient');
	Route::get('dashboard', 'AuthClientController@home');
	Route::post('data-user', 'AuthClientController@getUserData');
	Route::post('data-profiles', 'AuthClientController@getProfilesData');
});
