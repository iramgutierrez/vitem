<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

use Vitem\Filters\ACLFilter;

class SupplierRepo extends BaseRepo {

	protected $SupplierRepo;	

	public function getModel()
	{
		return new Supplier;
	}

	static function with($entities )
	{

		return \Supplier::with(parent::with($entities));


	}

}