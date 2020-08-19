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
        $verify_user=HubUsers::getUserAuth($verify_token->data->access_token);
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
            'api_token'=>$verify_user['user']['access_token'],
            'email_verified_at'=>$verify_user['user']['email_verified_at'],
            'info_json'=>$info
          ]); 
        }

        return $next($request);     
      } 
    }   

    if ($request->ajax()) {
        return response('Token invalido.', 401);
    }
  }   
}
