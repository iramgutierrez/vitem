<?php namespace Vitem\WebServices;

use Vitem\Repositories\ProductRepo;


class ProductWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' ])->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$product = \Product::where('id' , $id)->first();

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

		return \Response::json(ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' ])
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

		$products = ProductRepo::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' ])
							->orderBy('stock' ,'asc')
							->where('stock' , '<=' , $limitStock)
							->get();

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

}