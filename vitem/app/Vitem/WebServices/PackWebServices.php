<?php namespace Vitem\WebServices;

use Vitem\Repositories\PackRepo;


class PackWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Pack::with('products')->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$supplier = \Pack::where('id' , $id)->first();

		return \Response::json($supplier);

	}
	static function getProducts(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$pack = PackRepo::getProducts($id);

		return \Response::json($pack);
	}
}