<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Auth;
use Bellpi\ConnectHubUsers\Utilities\Helpers;
use Symfony\Component\HttpFoundation\Cookie;
use Bellpi\ConnectHubUsers\Facades\HubSession;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth as AuthHub;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Http\Response;

class AuthController {	  
    public function __construct(){
       $this->route=config('hub-paths.base').config('hub-paths.group');
    }

    //-------------Validar o refrescar token------------------
    public function checkToken($service_key, $token){
      $data=[
        'token'=>$token
      ];
      $route= config('hub-paths.path_token');  
      $response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_token').config('hub-service-key.key'),$data);
      return $response;
    }
    //---------------------------------------------------------

    //---------------Ejecutar login en la aplicacion-----------------
  	public function login($profile_key, $data){
  		$response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_login').config('hub-service-key.key').'/'.$profile_key,$data);
      sleep(5);
      if($response){
        $_response=json_decode($response);    
        if($_response->data){
          $token=$_response->data->access_token;
          $this->setSessionToken($token);
        }
      }
  		return $response;
    }  
    //------------------------------------------------------------

    //-------------Data Perfil Usuario----------------------------
    public function getUserProfile($profile_key){
      $data=[
        'accessToken'=>session('hub_ssk')
      ];
  
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user').config('hub-service-key.key').'/'.$profile_key,$data);
      return $response;
    }

    //--------------------------------------------------------------

    //--------------Info usuario autenticado------------------------
    public function getUserAuth(){
      $data=[
        'accessToken'=>session('hub_ssk')
      ];
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user').config('hub-service-key.key'),$data);
      return $response;
    }
    //---------------------------------------------------------------

    //-------------Data Menú Splash----------------------------------
    public function getUserInfoServices(){
      $data=[
        'accessToken'=>session('hub_ssk')
      ];

      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_services'),$data);
      return $response;
    }
    //-----------------------------------------------------------------

    //------Listado de perfiles habilitados para el servicio-----------

    public function getProfilesService($service_key, $data){
      $data=[
          'accessToken'=>session('hub_ssk')
        ]; 
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_profiles').$service_key,$data);
      return $response;
    }
    //------------------------------------------------------------------

    //-----------------Actualizacion perfiles usuario-------------------
    public function userUpdate($key,$data){
       $data=[
          'accessToken'=>session('hub_ssk')
        ]; 
       $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user_create').$key,$data);
       return $response;
    }
    //-------------------------------------------------------------------

    public function logout(){ 
       $data=[
          'accessToken'=>session('hub_ssk')
        ];
       $response=Helpers::httpPostJson($this->route.config('hub-paths.path_logout').config('hub-service-key.key'),$data);
       \Session::forget('hub_ssk');
       \Session::save();
       return $response;
    }

     public function setSessionToken($token){
      $response = new Response(); 
      \Session::put('hub_ssk',$token);
      \Session::save();
      return $response;
    }

}
