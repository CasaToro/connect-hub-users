<?php

namespace Bellpi\ConnectHubUsers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class ConnectHubUsersServiceProvider extends ServiceProvider
{

    public function boot()
    {
      $this->publishes([$this->basePath('config/hub-paths.php')=>base_path('config/hub-paths.php')],'hub-users-paths');
    }

    public function register()
    {
     	$this->app->bind('hub-users',function(){
        return new Http\Controllers\Auth\AuthController;
      });

      $this->app->bind('hub-session',function(){
        return new Http\Controllers\Session\SessionController;
      });

      $router = $this->app['router'];
      $router->aliasMiddleware('hub-users-auth', Http\Middleware\CheckToken::class);
      $this->mergeConfigFrom($this->basePath('config/hub-paths.php'),'hub-paths');
    } 


    protected function basePath($path=''){
        return __DIR__.'/../'.$path;
    }
}