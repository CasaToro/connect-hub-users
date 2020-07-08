<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Auth;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Bellpi\ConnectHubUsers\Facades\HubConnection;
use Illuminate\Http\Request;

class AuthController {	  
  	public function login($service_key, $profile_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_login');
  		$response=Helpers::httpPostJsonWithOutToken($route.$service_key.'/'.$profile_key,$data);
  		return $response;
  	}

    public function getProfilesService($service_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_profiles');
      $response=Helpers::httpPostJson('http://hub_users.test/api/v1/client/list-profiles/'.$service_key,$data);
      return $response;
    }

    public function userUpdate($key,$data){ 
       $response=Helpers::httpPostJson('http://hub_users.test/api/v1/client/user/update/'.$key,$data);
       return $response;
    }
}