<?php namespace Vitem\WebServices;

use Vitem\Repositories\DevolutionRepo;


class DevolutionWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Devolution::with(['user' , 'supplier','products'])->get());

	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$destination = \Devolution::where('id' , $id)->first();

		return \Devolution::json($destination);

	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$operatorOrderDate = (!empty($_GET['operatorOrderDate'])) ? $_GET['operatorOrderDate'] : false;

		$orderDate = (!empty($_GET['orderDate'])) ? $_GET['orderDate'] : false;

		$devolutions = [

			'data' => DevolutionRepo::findByPage($page , $perPage , $find , $operatorOrderDate , $orderDate ),
			'total' => DevolutionRepo::countFind($find , $operatorOrderDate ,$orderDate )
		];

		return \Response::json($devolutions);
	}

	static function getProducts(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$products = DevolutionRepo::getProducts($id);

		return \Response::json($products);
	}

	static function getMaxProducts()
	{
		return $maxProducts = \DB::table('devolution_product')
					->select(\DB::raw('devolution_id') , \DB::raw('count(*) as count'))
					->groupBy('devolution_id')
					->orderBy('count' ,'desc')
					->take(1)
					->first()
					->count;
	}
}