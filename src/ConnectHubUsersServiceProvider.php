<?php

namespace Bellpi\ConnectHubUsers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class ConnectHubUsersServiceProvider extends ServiceProvider
{

    public function boot()
    {
      $this->LoadViewsFrom($this->basePath('resources/views'),'hub-users'); 
      $this->LoadMigrationsFrom($this->basePath('database/migrations'));
      $this->publishes([$this->basePath('config/hub-paths.php')=>base_path('config/hub-paths.php')],'hub-users-paths');
      $this->publishes([$this->basePath('config/hub-service-key.php')=>base_path('config/hub-service-key.php')],'hub-users-keys');
      $this->publishes([$this->basePath('resources/assets')=>public_path('vendor/hub-users')
        ],'hub-users-assets');
      $this->publishes([$this->basePath('resources/js/components')=>base_path('resources/js/hub-users/components')
        ],'hub-users-components');

    }

    public function register()
    {
     	$this->app->bind('hub-users',function(){
        return new Http\Controllers\Auth\AuthController;
      });

      $router = $this->app['router'];
      $router->aliasMiddleware('hub-users-auth', Http\Middleware\CheckToken::class);
      $router->aliasMiddleware('hub-users-profiles', Http\Middleware\CheckProfiles::class);
      $router->aliasMiddleware('hub-users-modules', Http\Middleware\CheckModules::class);
      $router->aliasMiddleware('json', Http\Middleware\EnforceJson::class);  
      $this->mergeConfigFrom($this->basePath('config/hub-paths.php'),'hub-paths');
      $this->mergeConfigFrom($this->basePath('config/hub-service-key.php'),'hub-service-key');
      $this->publishes([__DIR__.'/Models'=>base_path('/app')
        ],'hub-users-models');
    } 


    protected function basePath($path=''){
        return __DIR__.'/../'.$path;
    }
}