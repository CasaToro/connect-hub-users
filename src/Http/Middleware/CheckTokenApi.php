<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
use Illuminate\Support\Facades\Config;
use Bellpi\ConnectHubUsers\Facades\HubUsers;
use App\HubUser;
use Auth;
use Closure;
class CheckTokenApi
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

    //Utilizara el token para validar o refrescorlo a su vez actualizara info del usuario
    //Se debe utilizar para servicios API
    $token = $request->api_token;

    if(!$token){
      if ($request->ajax()) {
        return response('No autorizado.', 401);
      }
    }

    $_verify_token=HubUsers::checkToken($token); 
    $verify_token=json_decode($_verify_token);
    if($verify_token && $token){
       if($verify_token->status == 'OK'){
          $verify_user=HubUsers::feedLocalUser($verify_token->data->access_token);
          Auth::guard((config('hub-auth.guard-hub')))->loginUsingId($verify_user->id, false);        
        } 
        return $next($request);     
      } 
    }   

    if ($request->ajax()) {
        return response('Token invalido.', 401);
    }
  }   
}
