<?php

namespace Bellpi\ConnectHubUsers\Facades;

use Illuminate\Support\Facades\Facade;

class HubSession extends Facade
{
	protected static function getFacadeAccessor(){
		return 'hub-session';
	}
}