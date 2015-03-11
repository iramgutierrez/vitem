<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

class PackRepo extends BaseRepo {

	public function getModel()
	{
		return new Pack;
	}

	static function all(){

		return \Store::all();
		
	}

	static function find2($id){

		return ($id);
		
	}

	static function getProducts($packId)
	{
		if(!PermissionRepo::checkAuth('Product' , 'Read') )
		{
			return [];
		}
		
		$pack = \Pack::where('id' , $packId)->first();

		if(!$pack)
			return false;

		return $pack->products;
	}

	static function with($entities )
	{

		return \Pack::with(parent::with($entities));


	}


}