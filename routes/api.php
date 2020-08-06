<?php 
Route::group(['middleware' => ['sessions']], function () {
	/*Route::post('set-token/{token}','Auth\AuthController@setSessionToken');
	Route::get('hub-user-info','Auth\AuthController@getUserInfo');*/
});

