<?php namespace Vitem\WebServices;

//use Vitem\Repositories\CommissionRepo;


class CommissionWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Sale::with('products')
									->with('packs')
									->with('user')
									->with(['employee' , 'employee.user'])
									->with('client')
									->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$commission = \Commission::with(['employee.user', 'sale.employee.user', 'sale.sale_payments.employee.user' ,'sale_payments.employee.user'])
						 ->where('id' , $id)->first();

		return \Response::json($commission);

	}

	static function getProducts(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$products = SaleRepo::getProducts($id);

		return \Response::json($products);
	}

	static function getPacks(){

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$packs = SaleRepo::getPacks($id);

		return \Response::json($packs);
	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$operatorSaleDate = (!empty($_GET['operatorSaleDate'])) ? $_GET['operatorSaleDate'] : false;

		$saleDate = (!empty($_GET['saleDate'])) ? $_GET['saleDate'] : false;

		$sales = [
		
			'data' => SaleRepo::findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate ),
			'total' => SaleRepo::countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate )
		];

		return \Response::json($sales);
	}
}