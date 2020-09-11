<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use Closure;
class CheckProfiles
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  
  public function handle($request, Closure $next)
  {
    
    //Excluir del array las parametros request y closure, para obtener los parametros que se definen 
    //en el middleware de cada contralador
    
    $keys_profiles = array_slice(func_get_args(), 2);

    $token = session('hub_ssk');
    if(!$token){
      if ($request->ajax()) {
        $data_error=[
          "status"=>"ERROR",
          "statusCode"=>401,
          "message"=>"No se ha podido encontrar token",
          "data"=>""
        ];
        return response($data_error, 401);
      }
      return abort(401);
    }

    $user_profiles=[];
    $_verify_user=HubUsers::getUserAuth($token);
    $verify_user=json_decode($_verify_user);
    if($verify_user){
       if($verify_user->user->profiles && count($verify_user->user->profiles)>0){
         $user_profiles=$verify_user->user->profiles;
         foreach ($user_profiles as $u_profile) {
            foreach ($keys_profiles as $k_profile) {
              if($u_profile->key == $k_profile){
                return $next($request);                  
              }
            }
         }     
       }
    }

    if ($request->ajax()) {
      $data_error=[
          "status"=>"ERROR",
          "statusCode"=>401,
          "message"=>"El perfil no esta autorizado",
          "data"=>""
        ];
        return response($data_error, 401);
    }

    return abort(401);
 
  }   
}