<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class SaleRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $sales;

	public function getModel()
	{
		return new \Sale;
	}

	static function all(){

		return \Sale::all();
		
	}

	static function getProducts($saleId)
	{

		if(!$saleId)
			return [];

		$canReadProducts = PermissionRepo::checkAuth('Product' , 'Read');

		if(!$canReadProducts)
			return [];

		$sale = self::with(['products']); 

		$sale = $sale->where('id' , $saleId);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sale = $sale->whereIn( 'employee_id' , $whereUserId);

        $sale = $sale->first();

        if(isset($sale->products))        	
			return $sale->products;

		return [];
	}

	static function getPacks($saleId)
	{
		if(!$saleId)
			return [];

		$canReadPacks = PermissionRepo::checkAuth('Pack' , 'Read');

		if(!$canReadPacks)
			return [];

		$sale = self::with(['packs']); 
		
		$sale = $sale->where('id' , $saleId);

		$whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $sale = $sale->whereIn( 'employee_id' , $whereUserId);

        $sale = $sale->first();

        if(isset($sale->packs))        	
			return $sale->packs;

		return [];
	}

	static function findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , $employee_id = false , $client_id = false , $product_id = false)
	{		

		$offset = ($page - 1 ) * $perPage;

		self::$sales = \Sale::with([
										'products',
										'packs',
										'employee' , 
										'employee.user',
										'client',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									]);
		
		self::generateLikeCondition( $find , ['id' , 'sheet']);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateProductIdCondition( $product_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateCondition( $operatorSaleDate , $saleDate);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		return self::$sales->get();

	}

	static function countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate , $employee_id = false , $client_id = false , $product_id = false)
	{				
		


		self::$sales = \Sale::with([
										'products',
										'packs',
										'employee' , 
										'employee.user',
										'client',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									]);

		self::generateLikeCondition( $find , ['id' , 'sheet']);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateProductIdCondition( $product_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateCondition( $operatorSaleDate , $saleDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		return self::$sales->count();		

	}

	static function findByPageReport($page , $perPage , $employee_id , $client_id , $sale_type , $pay_type , $initDate , $endDate )
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$sales = \Sale::with([
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
									]);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateRangeCondition( $initDate , $endDate);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);


		return self::$sales->get();		

	}

	static function countFindReport($employee_id , $client_id  , $sale_type , $pay_type , $initDate , $endDate )
	{				
		


		self::$sales = \Sale::with([
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
									]);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateRangeCondition( $initDate , $endDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);


		return self::$sales->count();		

	}

	static function findReport($employee_id , $client_id  , $sale_type , $pay_type , $initDate , $endDate )
	{				
		


		self::$sales = \Sale::with([
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
									]);

		if($employee_id){

			self::generateEmployeeIdCondition( $employee_id);

		}

		if($client_id){

			self::generateClientIdCondition( $client_id);		

		}
		
		if($sale_type){

			self::generateSaleTypeCondition( $sale_type);		

		}
		
		if($pay_type){

			self::generatePayTypeCondition( $pay_type);		

		}
		
		if($initDate && $endDate){

			self::generateSaleDateRangeCondition( $initDate , $endDate);

		}

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		

		return self::$sales->get();		

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$sales->where(
							function($query) use ($sentence , $fields) {
								
								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}
							
						);

		}

	}

	private static function generateEmployeeIdCondition( $employee_id )
	{

		if( $employee_id != '' ){
		
			self::$sales->where( 'employee_id', '=' ,$employee_id );

		}

	}

	private static function generateClientIdCondition( $client_id )
	{

		if( $client_id != '' ){
		
			self::$sales->where( 'client_id', '=' ,$client_id );

		}

	}

	private static function generateProductIdCondition( $product_id )
	{

		if( $product_id != '' ){

			self::$sales->whereIn('id', function ($query) use ($product_id) {

				$query->select(\DB::raw('sale_id'))
						->from('product_sale')
						->where('product_sale.product_id' , '=' , $product_id);

			});

		}

	}

	private static function generateSaleTypeCondition( $sale_type )
	{

		if( $sale_type != '' ){
		
			self::$sales->where( 'sale_type', '=' ,$sale_type );

		}

	}

	private static function generatePayTypeCondition( $pay_type )
	{

		if( $pay_type != '' ){
		
			self::$sales->where( 'pay_type', '=' ,$pay_type );

		}

	}

	private static function generateSaleDateCondition( $operatorSaleDate , $saleDate )
	{

		if( $operatorSaleDate && $saleDate){
		
			self::$sales->where( 'sale_date', $operatorSaleDate ,$saleDate );

		}

	}



	private static function generateSaleDateRangeCondition( $initDate , $endDate )
	{

		if( $initDate && $endDate){
		
			self::$sales
					->where( 'sale_date', '>=' ,$initDate )
					->where( 'sale_date', '<=' ,$endDate );

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$sales->skip($offset)
					   ->take($perPage);

	}

	static function getRemainingPayment( $sale )
	{
		if($sale->sale_type != 'apartado')
		{
			return false;
		}

		$clearedPayment = self::getClearedPayment($sale);

		$total = $sale->total;

		return $total - $clearedPayment;


	}

	static function getClearedPayment( $sale )
	{
		if($sale->sale_type != 'apartado')
		{
			return false;
		}

		$clearedPayment = 0;

		if($sale->sale_payments)
		{
			foreach($sale->sale_payments as $sale_payment)
			{

				$clearedPayment += $sale_payment->subtotal;
			}
			
		}

		

		return $clearedPayment;


	}

	static function getByRange($init , $end , $groupBy)
	{
		$initDate = date('Y-m-d' , $init);

		$endDate = date('Y-m-d' , $end);

		$daysRange = [];

		$day = $init;

		$field;

		switch($groupBy){
			case 'day':
				$field = 'sale_date';
				break;
			case 'week':
				$field = 'week';
				break;
			case 'month':
				$field = 'month';
				break;
			default:
				$field = 'sale_date';
				break;
		}

		$fieldFormat;

		switch($groupBy){
			case 'day':
				$fieldFormat = 'Y-m-d';
				break;
			case 'week':
				$fieldFormat = 'W';
				break;
			case 'month':
				$fieldFormat = 'm';
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

		self::$sales = \Sale::with(['user']);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);


		//self::generateSaleTypeCondition( 'contado');

		self::generateDateRangeCondition( $initDate , $endDate);

		$sales = self::$sales->get();

		$salesByRange = [];

		

		foreach($sales as $k => $sale)
		{

			if(!isset($salesByRange[$sale[$field]]))
			{
			
				$salesByRange[$sale[$field]] = 0;
			
			}

			$salesByRange[$sale[$field]] += $sale->total;

		}

		//$salesByRange = $salesByRange + $daysRange;

		//ksort($salesByRange);

		return $salesByRange;

	}

	private static function generateDateRangeCondition( $initDate , $endDate )
	{

		self::$sales
				->where('sale_date' , '>=' , $initDate)
				->where('sale_date' , '<=' , $endDate);

	}

	static function with($entities )
	{

		return \Sale::with(parent::with($entities));


	}

	/*public function find($id)
	{

		return parent->find($id);


	}*/

}