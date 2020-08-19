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
              'access_token'=>$verify_user['user']['access_token'],
              'email_verified_at'=>$verify_user['user']['email_verified_at'],
              'info_json'=>$info
            ]); 
          $hub_user=HubUser::where('email',$verify_user['user']['email'])->first();
          Auth::guard((config('hub-auth.guard-hub')))->loginUsingId($hub_user->id, false);
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
    }   

    if ($request->ajax()) {
        return response('No autorizado.', 401);
    }
    return redirect(config('hub-paths.route_local_login'));
  }   
}
