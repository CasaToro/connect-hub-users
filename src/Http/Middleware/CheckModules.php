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
      $user_profiles=[];
      $_verify_user=HubUsers::getUserAuth(config('hub-service-key.key'),$token);
      $verify_user=json_decode($_verify_user);
      if($verify_user){
        if($verify_user->user->profiles && count($verify_user->user->profiles)>0){
          $user_profiles=$verify_user->user->profiles;
          foreach ($user_profiles as $u_profile) {
            $available_modules=$u_profile->available_modules;
            foreach ($available_modules as $module) {
               foreach ($keys_modules as $k_module) {
                if($module->slug == $k_module){
                  return $next($request);                  
                }
              }
            }
          }     
        }
      }
                   
      if ($request->ajax()) {
          return response('No autorizado.', 401);
      }

      return abort(401);
 
  }   
       
   
}
