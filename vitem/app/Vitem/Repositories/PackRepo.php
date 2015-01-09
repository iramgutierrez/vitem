<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class PackRepo extends BaseRepo {

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

	static function getProducts($packId)
	{
		$pack = \Pack::where('id' , $packId)->first();

		if(!$pack)
			return false;

		return $pack->products;
	}

}