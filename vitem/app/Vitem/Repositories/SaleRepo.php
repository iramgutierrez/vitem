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
        return new Sale;
    }

	static function all(){

		return \Sale::all();
		
	}

	static function getProducts($saleId)
	{
		$sale = \Sale::where('id' , $saleId)->first();

		if(!$sale)
			return false;

		return $sale->products;
	}

	static function getPacks($saleId)
	{
		$sale = \Sale::where('id' , $saleId)->first();

		if(!$sale)
			return false;

		return $sale->packs;
	}

	static function findByPage($page , $perPage , $find , $sale_type , $pay_type , $operatorSaleDate , $saleDate )
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
		
		self::generateLikeCondition( $find , ['id' , 'sheet']);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateCondition( $operatorSaleDate , $saleDate);

		self::paginate($offset , $perPage);

		return self::$sales->get();		

	}

	static function countFind($find , $sale_type , $pay_type , $operatorSaleDate , $saleDate )
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

		self::generateLikeCondition( $find , ['id' , 'sheet']);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeCondition( $pay_type);

		self::generateSaleDateCondition( $operatorSaleDate , $saleDate);

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

				$clearedPayment += $sale_payment->quantity;
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

}