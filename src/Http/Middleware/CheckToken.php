<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
use Illuminate\Support\Facades\Config;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
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
    $token = session('hub_ssk');
    if(!$token){
      return redirect(config('hub-paths.route_local_login'));
    }

    $_verify_token=HubUsers::checkToken(config('hub-service-key.key'),$token); 
    
    $verify_token=json_decode($_verify_token);
    
    if($verify_token && $token){
      if($verify_token->status == 'OK'){   
        if($token != $verify_token->data->access_token){
          \Session::put('hub_ssk',$verify_token->data->access_token);
          \Session::save();
        }             
        return $next($request);     
      } 
    }   

    if ($request->ajax()) {
        return response('No autorizado.', 401);
    }
    return redirect(config('hub-paths.route_local_login'));
  }   
}
