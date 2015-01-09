<?php namespace Vitem\WebServices;

use Vitem\Repositories\ProductRepo;


class ProductWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Product::with('Supplier')->with('User')->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$supplier = \Product::where('id' , $id)->first();

		return \Response::json($supplier);

	}	

	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$status = (isset($_GET['status'])) ? $_GET['status'] : ''; 

		$products = [
		
			'data' => ProductRepo::findByPage($page , $perPage , $find , $status),
			'total' => ProductRepo::countFind($find , $status)
		];

		return \Response::json($products);
	}

	static function getFinishedComing()
	{

		$limitStock = (!empty($_GET['limitStock'])) ? $_GET['limitStock'] : 5; 

		$products = \Product::with('supplier')
							->orderBy('stock' ,'asc')
							->where('stock' , '<=' , $limitStock)
							->get();

		return \Response::json($products);
	}

}