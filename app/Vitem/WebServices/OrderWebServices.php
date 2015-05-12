<?php namespace Vitem\WebServices;

use Vitem\Repositories\OrderRepo;


class OrderWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Order::with(['user' , 'supplier','products'])->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$destination = \Destination::where('id' , $id)->first();

		return \Response::json($destination);

	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$operatorOrderDate = (!empty($_GET['operatorOrderDate'])) ? $_GET['operatorOrderDate'] : false;

		$orderDate = (!empty($_GET['orderDate'])) ? $_GET['orderDate'] : false;

		$orders = [
		
			'data' => OrderRepo::findByPage($page , $perPage , $find , $operatorOrderDate , $orderDate ),
			'total' => OrderRepo::countFind($find , $operatorOrderDate ,$orderDate )
		];

		return \Response::json($orders);
	}

	static function getProducts(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$products = OrderRepo::getProducts($id);

		return \Response::json($products);
	}

	static function getMaxProducts()
	{
		return $maxProducts = \DB::table('order_product')
					->select(\DB::raw('order_id') , \DB::raw('count(*) as count'))
					->groupBy('order_id')
					->orderBy('count' ,'desc')
					->take(1)
					->first()
					->count; 
	}
}