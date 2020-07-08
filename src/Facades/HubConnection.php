<?php

namespace Bellpi\ConnectHubUsers\Facades;

use Illuminate\Support\Facades\Facade;

class HubConnection extends Facade
{
	protected static function getFacadeAccessor(){
		return 'hub-connection';
	}
}