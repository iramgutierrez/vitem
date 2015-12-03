<?php namespace Vitem\WebServices;

use Vitem\Repositories\PackRepo;


class PackWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Pack::with('products.stores' , 'discounts' , 'products.discounts')->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$pack = PackRepo::with(['products'])->where('id' , $id)->first();

		return \Response::json($pack);

	}
	static function getProducts(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$pack = PackRepo::getProducts($id);

		return \Response::json($pack);
	}

	static function getMaxProducts()
	{
		return $maxProducts = \DB::table('pack_product')
					->select(\DB::raw('pack_id') , \DB::raw('count(*) as count'))
					->groupBy('pack_id')
					->orderBy('count' ,'desc')
					->take(1)
					->first()
					->count; 
	}
}