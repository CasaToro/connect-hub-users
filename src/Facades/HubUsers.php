<?php

namespace Bellpi\ConnectHubUsers\Facades;

use Illuminate\Support\Facades\Facade;

class HubUsers extends Facade
{
	protected static function getFacadeAccessor(){
		return 'hub-users';
	}
}