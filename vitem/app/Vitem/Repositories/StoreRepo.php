<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class StoreRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	static function all(){

		return \Store::all();
		
	}

	static function find2($id){

		return ($id);
		
	}

}