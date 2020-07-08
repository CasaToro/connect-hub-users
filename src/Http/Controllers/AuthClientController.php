<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers;
use Illuminate\Http\Request;
use Bellpi\ConnectHubUsers\Facades\HubConnection;
use Illuminate\Support\Facades\Config;
use Bellpi\ConnectHubUsers\Facades\HubUsers;

class AuthClientController {	 
	public function showLoginForm(){
		
		return view('hub-users::auth.login');
	}

	public function loginClient(Request $request){

		if(request()->ajax()){
			return HubUsers::login($request->all());
		}
	}

	public function home(){
		return view('hub-users::dashboard');
	}

	public function getUserData(Request $request){
		if(request()->ajax()){
			return HubUsers::getUser($request->all());
		}
	}

	public function getProfilesData(Request $request){
		if(request()->ajax()){
			return HubUsers::getProfiles($request->all(), $request->service_key);
		}

	}
}