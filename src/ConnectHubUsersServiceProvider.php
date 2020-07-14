<?php

namespace Bellpi\ConnectHubUsers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class ConnectHubUsersServiceProvider extends ServiceProvider
{

    public function boot()
    {

      /*$this->LoadViewsFrom($this->basePath('resources/views'),'hub-users'); 
       $this->publishes([
          $this->basePath('/resources/assets/js/components') => base_path('resources/js/components/hub-users'),
      ], 'hub-users-components');
      $this->publishes([$this->basePath('resources/assets')=>public_path('vendor/hub-users')
        ],'hub-users-assets');*/
     /* Config::set('token_hub_user','');*/   
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
      $router->aliasMiddleware('hub-users-ssk', Http\Middleware\AddHeader::class);

      $this->mergeConfigFrom($this->basePath('config/hub-paths.php'),'hub-paths');
      /*$this->mergeConfigFrom($this->basePath('config/hub-session.php'),'hub-session');*/
    } 


    protected function basePath($path=''){
        return __DIR__.'/../'.$path;
    }
}