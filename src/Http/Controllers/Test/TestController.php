<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Test;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use Illuminate\Http\Request;
use App\HubUser;
use Auth;

class TestController {
	public function showLoginFormTest(){
		return view('hub-users::auth.login');
	}
	public function login(Request $request){
		$data=[
			'email'=>$request->email,
			'password'=>$request->password
		];
		$response=HubUsers::login($request->profile_key,$data);
		return $response;
	}

	public function home(){
		//dd(Auth::user());
		return view('hub-users::home');
	}

	public function infoUserAuth(Request $request){
		$response=HubUsers::getUserAuth($request->access_token);
		return $response;
	}

	public function infoUserProfile(Request $request){
		$response=HubUsers::getUserProfile($request->profile_key);
		return $response;
	}

	public function logout(Request $request){
		$response=HubUsers::logout($request);
		return $response;
	}	

}	