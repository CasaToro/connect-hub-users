<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Auth;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Symfony\Component\HttpFoundation\Cookie;
use Bellpi\ConnectHubUsers\Facades\HubSession;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController {	  
    public function __construct(){
       $this->route=config('hub-paths.base').config('hub-paths.group');
    }

    public function checkToken($service_key, $token){
      $route= config('hub-paths.path_token');
      $data=[
        'token'=>$token
      ];
      $response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_token').$service_key,$data);
      return $response;
    }

  	public function login($service_key, $profile_key, $data){
  		$response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_login').$service_key.'/'.$profile_key,$data);
      sleep(5);
      if($response){
        $_response=json_decode($response);    
        if($_response->data){
          $this->setSessionToken($_response->data->access_token);
        }
      }
  		return $response;
  	}

    public function getUserProfile($service_key, $profile_key, $data){
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user').$service_key.'/'.$profile_key,$data);
      return $response;
    }

    public function getUserAuth($service_key,$data){
      $data=[
        'token'=>$token
      ];
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user').$service_key,$data);
      return $response;
    }

    public function getProfilesService($service_key, $data){
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_profiles').$service_key,$data);
      return $response;
    }

    public function userUpdate($key,$data){ 
       $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user_create').$key,$data);
       return $response;
    }

     public function setSessionToken($token){
      $response = new Response(); 
      \Session::put('hub_ssk',$token);
      \Session::save();
      return $response;
    }
}
