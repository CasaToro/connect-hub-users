<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Auth;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Bellpi\ConnectHubUsers\Facades\HubConnection;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class AuthController {	  

    public function checkToken($data){
      $route= config('hub-paths.base').config('hub-paths.group');
      $response=Helpers::httpPostJsonWithOutToken($route.'checkToken/'.$service_key,$data);
      return $response;
    }

  	public function login($service_key, $profile_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_login');
  		$response=Helpers::httpPostJsonWithOutToken($route.$service_key.'/'.$profile_key,$data);
      $_response=json_decode($response);
     
      if($_response->data->user){
         Config::set('token_hub_user',$_response->data->user->access_token);
      }
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