<?php 
Route::group(['middleware' => ['web']], function () {
	Route::get('hub-users-info','Auth\AuthController@getUserInfoServices')->middleware(['hub-users-auth']);
});