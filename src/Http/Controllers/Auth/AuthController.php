<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Auth;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Symfony\Component\HttpFoundation\Cookie;
use Bellpi\ConnectHubUsers\Facades\HubSession;
use Illuminate\Support\Facades\Config;


use Illuminate\Http\Request;

class AuthController {	  

    public function checkToken($service_key, $token){
      $route= config('hub-paths.base').config('hub-paths.group');
      $data=[
        'token'=>$token
      ];
   
      $response=Helpers::httpPostJsonWithOutToken($route.'client/auth/check-token/'.$service_key,$data);
      return $response;
    }

  	public function login($service_key, $profile_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_login');

  		$response=Helpers::httpPostJsonWithOutToken($route.$service_key.'/'.$profile_key,$data);
      sleep(5);
      if($response){
        $_response=json_decode($response);    
        if($_response->data){
          $data = [
            'token'=>$_response->data->access_token
          ];
          session(['hub_ssk'=>$data['token']]);
        }
      }
  		return $response;
  	}

    public function getUserAuth($service_key, $profile_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_user');
      $response=Helpers::httpPostJson($route.$service_key.'/'.$profile_key,$data);
      return $response;
    }

    public function getProfilesService($service_key, $data){
      $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_profiles');
      $response=Helpers::httpPostJson($route.$service_key,$data);
      return $response;
    }

    public function userUpdate($key,$data){ 
       $route= config('hub-paths.base').config('hub-paths.group').config('hub-paths.path_user_create');
       $response=Helpers::httpPostJson($route.$key,$data);
       return $response;
    }
}
