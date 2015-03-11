<?php namespace Vitem\WebServices;

use Vitem\Repositories\SaleRepo;
use Vitem\Repositories\SalePaymentRepo;
use Vitem\Repositories\PackRepo;


class SaleWebServices extends BaseWebServices {

	protected $sale;

	public function __construct(SaleRepo $SaleRepo)
	{

		$this->sale = $SaleRepo;

	}


	/*public function getModel()
	{
		return new User;
	}*/

	public function all()
	{
		$sales = SaleRepo::with([
				'products',
				'packs',
				'employee.user',
				'client',
				'sale_payments',
				'commissions.employee.user',
				'delivery.employee.user',
				'delivery.destination',
				'pay_type'
			]);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sales = $sales->whereIn( 'employee_id' , $whereUserId);

        $sales = $sales->get();

		return \Response::json($sales);
	}

	static function getBySeller()
	{

		$employee_id = (isset($_GET['employee_id'])) ? $_GET['employee_id'] : false;

		if(!$employee_id)
			return [];

		$sales = SaleRepo::with([
				'products',
				'packs',
				'employee.user',
				'client',
				'sale_payments',
				'commissions.employee.user',
				'delivery.employee.user',
				'delivery.destination',
				'pay_type'
			]);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sales = $sales->whereIn( 'employee_id' , $whereUserId);

        $sales = $sales->where('employee_id' , $employee_id)->get();

		return \Response::json($sales);
		
	}

	static function findBySeller()
	{

		$employee_id = (!empty($_GET['employee_id'])) ? $_GET['employee_id'] : false; 

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$operatorSaleDate = (!empty($_GET['operatorSaleDate'])) ? $_GET['operatorSaleDate'] : false;

		$saleDate = (!empty($_GET['saleDate'])) ? $_GET['saleDate'] : false;

		$sales = [
		
			'data' => SaleRepo::findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , $employee_id),
			'total' => SaleRepo::countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , $employee_id)
		];

		return \Response::json($sales);
	}

	static function getByClient()
	{

		$client_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : false;

		if(!$client_id)
			return [];


		return \Response::json(\Sale::with([
										'products',
										'packs',
										'user',
										'employee' , 
										'employee.user',
										'client',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									])
						 			->where('client_id' , $client_id)
									->get());
		
	}

	static function findByClient()
	{

		$client_id = (!empty($_GET['client_id'])) ? $_GET['client_id'] : false; 

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$operatorSaleDate = (!empty($_GET['operatorSaleDate'])) ? $_GET['operatorSaleDate'] : false;

		$saleDate = (!empty($_GET['saleDate'])) ? $_GET['saleDate'] : false;

		$sales = [
		
			'data' => SaleRepo::findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , false ,$client_id),
			'total' => SaleRepo::countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , false, $client_id)
		];

		return \Response::json($sales);
	}
	static function getByProduct()
	{

		$product_id = (isset($_GET['product_id'])) ? $_GET['product_id'] : false;

		if(!$product_id)
			return [];


		return \Response::json(\Sale::with([
										'products',
										'packs',
										'user',
										'employee' , 
										'employee.user',
										'client',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									])
						 			->whereIn('id', function ($query) use ($product_id) {

										$query->select(\DB::raw('sale_id'))
												->from('product_sale')
												->where('product_sale.product_id' , '=' , $product_id);

									})
									->get());
		
	}

	static function findByProduct()
	{

		$product_id = (!empty($_GET['product_id'])) ? $_GET['product_id'] : false; 

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$operatorSaleDate = (!empty($_GET['operatorSaleDate'])) ? $_GET['operatorSaleDate'] : false;

		$saleDate = (!empty($_GET['saleDate'])) ? $_GET['saleDate'] : false;

		$sales = [
		
			'data' => SaleRepo::findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , false ,false , $product_id),
			'total' => SaleRepo::countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , false, false , $product_id)
		];

		return \Response::json($sales);
	}


	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return [];

		$sales = SaleRepo::with([
				'products',
				'packs',
				'employee.user',
				'client',
				'sale_payments',
				'commissions.employee.user',
				'delivery.employee.user',
				'delivery.destination',
				'pay_type'
			]);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sales = $sales->whereIn( 'employee_id' , $whereUserId);

        $sales = $sales->where('id' , $id)->get();

		return \Response::json($sales);

	}

	static function findBySheet()
	{
		$sheet = (isset($_GET['sheet'])) ? $_GET['sheet'] : false;

		if(!$sheet)
			return [];

		$sales = SaleRepo::with([
				'products',
				'packs',
				'employee.user',
				'client',
				'sale_payments',
				'commissions.employee.user',
				'delivery.employee.user',
				'delivery.destination',
				'pay_type'
			]);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sales = $sales->whereIn( 'employee_id' , $whereUserId);

        $sales = $sales->where('sheet' , $sheet)->get();

		return \Response::json($sales);

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

	public function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$operatorSaleDate = (!empty($_GET['operatorSaleDate'])) ? $_GET['operatorSaleDate'] : false;

		$saleDate = (!empty($_GET['saleDate'])) ? $_GET['saleDate'] : false;

		$sales = [
		
			'data' => $this->sale->findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate ),
			'total' => $this->sale->countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate )
		];

		return \Response::json($sales);
	}

	static function findReport()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$employee_id = (!empty($_GET['employee_id'])) ? $_GET['employee_id'] : false;

		$client_id = (!empty($_GET['client_id'])) ? $_GET['client_id'] : false;

		$sale_type = (!empty($_GET['sale_type'])) ? $_GET['sale_type'] : false;

		$pay_type = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : false;

		$initDate = (!empty($_GET['initDate'])) ? $_GET['initDate'] : false;

		$endDate = (!empty($_GET['endDate'])) ? $_GET['endDate'] : false;

		$sales = [
		
			'data' => SaleRepo::findByPageReport($page , $perPage , $employee_id , $client_id , $sale_type , $pay_type , $initDate , $endDate ),
			'total' => SaleRepo::countFindReport($employee_id , $client_id  , $sale_type , $pay_type , $initDate , $endDate )
		];

		return \Response::json($sales);
	}

	static function getByRange()
	{
		$initDefault =time()- (400 * 24 * 60 * 60);

		$endDefault =  time() ;

		$showByDefault = 'day'; 

		$showSalesDefault = true;

		$showSalePaymentsDefault = true;


		$init = (!empty($_GET['init'])) ? $_GET['init'] : $initDefault;

		$end = (!empty($_GET['end'])) ? $_GET['end'] : $endDefault;

		$showBy = (!empty($_GET['showBy'])) ? $_GET['showBy'] : $showByDefault;

		$showSales = (!empty($_GET['showSales'])) ? $_GET['showSales'] : $showSalesDefault;

		$showSalePayments = (!empty($_GET['showSalePayments'])) ? $_GET['showSalePayments'] : $showSalePaymentsDefault;

		$sales = [];

		$salePayments = [];

		if($showSales == 'true'){
			$sales = SaleRepo::getByRange($init , $end , $showBy);
		}		

		if($showSalePayments == 'true'){
			$salePayments = SalePaymentRepo::getByRange($init , $end , $showBy);
		}		

		$daysRange = [];

		$fieldFormat;

		$day = $init;

		switch($showBy){
			case 'day':
				$fieldFormat = 'Y-m-d';
				break;
			case 'week':
				$fieldFormat = 'Y - W';
				break;
			case 'month':
				$fieldFormat = 'Y - m';
				break;
			default:
				$fieldFormat = 'Y-m-d';
				break;
		}

		while($day <= $end)
		{
			$dayDate = date($fieldFormat , $day);

			$daysRange[$dayDate] = 0;

			$day += (1 * 24 * 60 * 60);
		}

		foreach($daysRange as $day => $total)
		{
			$t = 0;

			if(isset($salePayments[$day]))
			{
				$t +=  $salePayments[$day];
			}

			if(isset($sales[$day]))
			{
				$t +=  $sales[$day];
			}

			$daysRange[$day] = $t;
		}

		return \Response::json($daysRange);

	}

	static function getSalesToday()
	{

		return \Response::make(\Sale::where('sale_date' , date('Y-m-d'))->count() , 200);

	}

	static function getPayTypes()
	{

		return \Response::json(\PayType::get());

	}
}