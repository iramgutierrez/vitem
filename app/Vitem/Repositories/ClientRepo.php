<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

use Vitem\Filters\ACLFilter;

class ClientRepo extends BaseRepo {

	protected $ClientRepo;	

	public function getModel()
	{
		return new User;
	}

	static function with($entities )
	{

		return \Client::with(parent::with($entities));


	}

}