<?php
namespace Bellpi\ConnectHubUsers\Http\Middleware;

use Closure;
class AddHeader
{
    /**
     * We only accept json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->add(['hub_ssk'=>'']);
        return $next($request);
    }
}
