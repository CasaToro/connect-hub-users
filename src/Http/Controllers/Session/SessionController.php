<?php 

namespace Bellpi\ConnectHubUsers\Http\Controllers\Session;
use Bellpi\ConnectHubUsers\Facades\HubSession;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;

class SessionController {	  

    public function setConfigKey($token){  
      parent::boot();
      Config::set('hub_sesk',$token);
    }
}