<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
use Illuminate\Support\Facades\Config;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use App\HubUser;
use Auth;
use Closure;
class CheckToken
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
    //Permitira usar el token que inicia sesión desde el administrador y lo establecera en la sesión que se este utilizando
    //Actualizara información del usuario y renovara el token establecido si este ha expirado
    $token = session('hub_ssk');

    if(!$token){
      if($request->api_token){
        $token = $request->api_token;
        \Session::put('profile',$request->profile);
        \Session::save();
      }  
    } 

    if(!$token){
      if ($request->ajax()) {
        return response('No autorizado.', 401);
      }
      return redirect(config('hub-paths.route_local_login'));
    }

    $_verify_token=HubUsers::checkToken($token); 
    $verify_token=json_decode($_verify_token);
    if($verify_token && $token){
      if($verify_token->status == 'OK'){
        $verify_user=HubUsers::feedLocalUser($verify_token->data->access_token);
        Auth::guard((config('hub-auth.guard-hub')))->loginUsingId($verify_user->id, false);        
      }  
   
      if($token != $verify_token->data->access_token){
        \Session::put('hub_ssk',$verify_token->data->access_token);
        \Session::save();
        $response = $next($request);
       
      }else{
        \Session::put('hub_ssk',$token);
        \Session::save();
        $response = $next($request);
        
      }        
        
      return $response;     
    } 
       

    if ($request->ajax()) {
        return response('No autorizado.', 401);
    }
    return redirect(config('hub-paths.route_local_login'));
    
  }   
}
