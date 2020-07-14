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
            
            $token = $request->session()->get('hub_ssk');
      
            $_verify_token=HubUsers::checkToken(env('SERVICE_HUB_KEY'),$token); 
            
            $verify_token=json_decode($_verify_token);
            
            if($verify_token){
                if($verify_token->status == 'OK'){   
                    if($token != $verify_token->data->access_token){
                       session(['hub_ssk'=>$verify_token->data->access_token]);
                    }             
                    return $next($request);     
                } 
            }   

            if ($request->ajax()) {
                return response('No autorizado.', 401);
            }

            return abort(401);
       
        }   
       
   
}
