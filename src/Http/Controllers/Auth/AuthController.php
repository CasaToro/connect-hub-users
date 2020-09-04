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
use App\HubUser;
use Session;
use Illuminate\Http\Response;

class AuthController {	  
    public function __construct(){
       $this->route=config('hub-paths.base').config('hub-paths.group');
    }

    //-------------Validar o refrescar token-------------------------
    public function checkToken($token){
      $data=[
        'token'=>$token
      ];
      $response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_token').config('hub-service-key.key'),$data);
      return $response;
    }
    //----------------------------------------------------------------

    //---------------Ejecutar login en la aplicacion------------------
  	public function login($profile_key, $data){
  		$response=Helpers::httpPostJsonWithOutToken($this->route.config('hub-paths.path_login').config('hub-service-key.key').'/'.$profile_key,$data);
      sleep(5);
      if($response){
        $_response=json_decode($response);    
        if($_response->data){
          $token=$_response->data->access_token;
          $this->setSessionToken($token, $profile_key);
          $hub_user=$this->feedLocalUser($token);
          Auth::guard((config('hub-auth.guard-hub')))->loginUsingId($hub_user->id, false);
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
      if($profile_key == null || $profile_key==""){
        $profile_key=session('profile');
      }
  
      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user').config('hub-service-key.key').'/'.$profile_key,$data);
      return $response;
    }

    //--------------------------------------------------------------

    //--------------Info usuario autenticado------------------------
    public function getUserAuth($token){
      $data=[
        'accessToken'=>$token
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

      $response=Helpers::httpPostJson($this->route.config('hub-paths.path_profiles').$service_key,$data);
      return $response;
    }
    //------------------------------------------------------------------

    //-----------------Actualizacion perfiles usuario-------------------
    public function userUpdate($key,$data){

       $response=Helpers::httpPostJson($this->route.config('hub-paths.path_user_create').$key,$data);
       return $response;
    }
    //-------------------------------------------------------------------

    //-----------------Cerrar Sesión-------------------------------------
    public function logout(Request $request){ 
       $data=[
          'accessToken'=>session('hub_ssk')
        ];
       $response=Helpers::httpPostJson($this->route.config('hub-paths.path_logout').config('hub-service-key.key'),$data);
       if($response){
        $_response=json_decode($response);    
        if($_response->status=='OK'){
          $this->guard(config('hub-auth.guard-hub'))->logout();
          \Session::forget('hub_ssk'); 
          \Session::forget('profile');
          \Session::save();
          $request->session()->invalidate();
          return $this->loggedOut($request) ?: redirect('/');
        }
      }
      return $response;
    }

         
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard($guard)
    {
        return Auth::guard($guard);
    }

    //------------------------------------------------------------------------

    //--------------------Poblar tabla de usuarios del paquete en local-------
    public function feedLocalUser($token){
      $verify_user=$this->getUserAuth($token);
      $verify_user=json_decode($verify_user,true);
      if($verify_user['user']){
        $info=array_merge($verify_user['user']['services'],$verify_user['user']['profiles']);
        $info=json_encode($info);
        HubUser::UpdateOrCreate(['id'=>$verify_user['user']['id']],
          [
            'id'=>$verify_user['user']['id'],   
            'name'=>$verify_user['user']['name'],
            'email'=>$verify_user['user']['email'],
            'password'=>$verify_user['user']['password'],
            'api_token'=>$verify_user['user']['api_token'],
            'email_verified_at'=>$verify_user['user']['email_verified_at'],
            'info_json'=>$info
          ]); 
        $hub_user=HubUser::where('email',$verify_user['user']['email'])->first();
        return $hub_user;
      }
      return false; 
    } 

    //------------------------------------------------------------------------------

    //--------------------Establecer token en sesion --------------------------------
     public function setSessionToken($token, $profile_key){
      $response = new Response(); 
      \Session::start();
      \Session::put('hub_ssk',$token);
      \Session::put('profile',$profile_key);      
      \Session::save();
      return $response;
    }
    //-------------------------------------------------------------------------------

}
