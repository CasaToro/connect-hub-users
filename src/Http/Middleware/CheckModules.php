<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
use Illuminate\Support\Facades\Config;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use Closure;
class CheckModules
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
      //Excluir del array las parametros request y closure, para obtener los parametros que se definen en el middleware de cada contralador
       
      $keys_modules = array_slice(func_get_args(), 2);
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
            $available_modules=$u_profile->available_modules;
            foreach ($available_modules as $module) {
               foreach ($keys_modules as $k_module) {
                if($module->key == $k_module){
                  return $next($request);                  
                }
              }
            }
          }     
        }
      }
                   
      if ($request->ajax()) {
          $data_error=[
            "status"=>"ERROR",
            "statusCode"=>401,
            "message"=>"El usuario no tiene acceso al módulo",
            "data"=>""
          ];
        return response($data_error, 401);
      }

      return abort(401);
 
  }   
       
   
}
