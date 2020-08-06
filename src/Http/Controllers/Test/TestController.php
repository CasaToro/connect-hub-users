<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Test;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use Illuminate\Http\Request;

class TestController {
	public function showLoginForm(){
		return view('hub-users::auth.login');
	}
	public function login(Request $request){
		$data=[
			'email'=>$request->email,
			'password'=>$request->password
		];
		$response=HubUsers::login($request->service_key, $request->profile_key,$data);
		return $response;
	}

	public function home(){
		return view('hub-users::home');
	}

	public function infoUserAuth(Request $request){
		$response=HubUsers::getUserAuth($request->service_key,$request->access_token);
		return $response;
	}

	public function infoUserProfile(Request $request){
		$data=[
			'accessToken' => session('hub_ssk')
		];
		$response=HubUsers::getUserProfile($request->service_key,$request->profile_key,$data);
		return $response;
	}	



}	