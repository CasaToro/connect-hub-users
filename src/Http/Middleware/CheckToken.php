<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;
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
    
            //Excluir del array las parametros request y closure, para obtener los parametros que se definen en el middleware de cada contralador
              
            dd($request);

               
                     

            if ($request->ajax()) {
                return response('No autorizado.', 401);
            }

            return abort(401);
       
        }   
       
   
}
