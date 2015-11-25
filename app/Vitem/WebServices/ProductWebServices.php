<?php namespace Vitem\WebServices;

use Vitem\Repositories\ProductRepo;


class ProductWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' , 'Segments' ])->limit(10)->orderBy('id','desc')->get());

	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$product = ProductRepo::with(['stores' , 'segments'])->where('id' , $id)->first();

		return \Response::json($product);

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

	static function getBySupplier()
	{

		$supplier_id = (!empty($_GET['supplier_id'])) ? $_GET['supplier_id'] : false;

		if(!$supplier_id)
		{
			return \Response::json([]);
		}

		return \Response::json(ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' , 'Store' ])
								->where('supplier_id' , $supplier_id)
								->get());

	}

	static function findBySupplier()
	{

		$supplier_id = (!empty($_GET['supplier_id'])) ? $_GET['supplier_id'] : false;

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$status = (isset($_GET['status'])) ? $_GET['status'] : '';

		$products = [

			'data' => ProductRepo::findByPage($page , $perPage , $find , $status , $supplier_id),
			'total' => ProductRepo::countFind($find , $status , $supplier_id)
		];

		return \Response::json($products);
	}

	static function getFinishedComing()
	{

		$limitStock = (!empty($_GET['limitStock'])) ? $_GET['limitStock'] : 5;

		$store_id = (!empty($_GET['store_id']) && $_GET['store_id'] > 0) ? $_GET['store_id'] : false;

		if($store_id)
		{

			$products = \Product::with(array('stores' => function($query) use ($store_id , $limitStock)
			{
			    $query->orderBy('quantity' ,'asc')
			    	  ->where('store_id', $store_id)
			    	  ->where('quantity', '<=' , $limitStock);

			}))->whereHas( 'stores' , function($query) use ($store_id , $limitStock)
			{
			    $query->orderBy('quantity' ,'asc')
			    	  ->where('store_id', $store_id)
			    	  ->where('quantity', '<=' , $limitStock);

			})->get();


		}
		else
		{
			$products = ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' , 'stores' ])
							->orderBy('stock' ,'asc')
							->where('stock' , '<=' , $limitStock)
							->get();

		}

		return \Response::json($products);
	}

	static function checkKey()
	{

		$key = (\Input::has('key')) ? \Input::get('key') : false;

		$product = \Product::where('key' , $key)->first();

		if($product)
		{

			return 0;

		}
		else
		{

			return "true";
		}

	}

	static function getSegmentProduct()
	{
		$id = (\Input::has('id')) ? \Input::get('id') : false;

		$product = \Product::with(['segments'])->where('id' , $id)->first();

		return $product->segments;
	}

}