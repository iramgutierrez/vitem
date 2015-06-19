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


		/*$sale = \Sale::with(['colors_products'])->where('id' , $saleId)->first();

		dd($sale);*/

		$sale = self::with(['products.colors' ,'colors_products']); 

		$sale = $sale->where('id' , $saleId);

		$whereUserId = \ACLFilter::generateAuthCondition();

    if(count($whereUserId))
        $sale = $sale->whereIn( 'employee_id' , $whereUserId);

    $whereStoreId = \ACLFilter::generateStoreCondition();

    if(count($whereStoreId))
        $sale = $sale->whereIn( 'store_id' , $whereStoreId);

    $sale = $sale->first();

		$sale = $sale->toArray();

		$colors = [];

		if(!empty($sale['colors_products']) && !empty($sale['products']))
		{
			foreach($sale['products'] as $p => $product)
			{
				$colors = [];
				
				foreach($sale['colors_products'] as $c => $color)
				{
					
					if($color['product_id'] == $product['id'])
					{
						$colors[] = $color;
						
					}
					
				}
				$sale['products'][$p]['colors_sale'] = $colors;
			}
		}

    if(isset($sale['products']))        	
			return $sale['products'];

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

        $whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            $sale = $sale->whereIn( 'store_id' , $whereStoreId);

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
										'store',
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

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);

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
										'store',
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

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);

		return self::$sales->count();		

	}

	static function findByPageReport($page , $perPage , $employee_id , $client_id , $sale_type , $pay_type_id , $initDate , $endDate , $percent_cleared_payment_type , $percent_cleared_payment)
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$sales = \Sale::with([
										'products',
										'packs',
										'user',
										'employee' , 
										'employee.user',
										'client',
										'store',
										'pay_type',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									]);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeIdCondition( $pay_type_id);

		self::generateSaleDateRangeCondition( $initDate , $endDate);

		self::generatePercentClearedPaymentCondition( $percent_cleared_payment_type , $percent_cleared_payment);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);

		return self::$sales->get();		

	}

	static function countFindReport($employee_id , $client_id  , $sale_type , $pay_type_id , $initDate , $endDate, $percent_cleared_payment_type , $percent_cleared_payment )
	{				
		


		self::$sales = \Sale::with([
										'products.store',
										'packs',
										'user',
										'employee' , 
										'employee.user',
										'client',
										'store',
										'pay_type',
										'sale_payments',
										'commissions.employee.user',
										'delivery.employee.user',
										'delivery.destination'
									]);

		self::generateEmployeeIdCondition( $employee_id);

		self::generateClientIdCondition( $client_id);

		self::generateSaleTypeCondition( $sale_type);

		self::generatePayTypeIdCondition( $pay_type_id);

		self::generateSaleDateRangeCondition( $initDate , $endDate);

		self::generatePercentClearedPaymentCondition( $percent_cleared_payment_type , $percent_cleared_payment);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);


		return self::$sales->count();		

	}

	static function findReport($employee_id , $client_id  , $sale_type , $pay_type_id , $initDate , $endDate , $percent_cleared_payment_type , $percent_cleared_payment)
	{				
		


		self::$sales = \Sale::with([
										'products',
										'packs',
										'user',
										'employee' , 
										'employee.user',
										'client',
										'store',
										'pay_type',
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
		
		if($pay_type_id){

			self::generatePayTypeIdCondition( $pay_type_id);		

		}
		
		if($initDate && $endDate){

			self::generateSaleDateRangeCondition( $initDate , $endDate);

		}
		
		if($percent_cleared_payment_type && $percent_cleared_payment){

			self::generatePercentClearedPaymentCondition( $percent_cleared_payment_type , $percent_cleared_payment);

		}

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$sales->whereIn( 'employee_id' , $whereUserId);

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);
		

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

	private static function generatePayTypeCondition( $pay_type)
	{

		if( $pay_type != '' ){
		
			self::$sales->where( 'pay_type', '=' ,$pay_type );

		}

	}

	private static function generatePayTypeIdCondition( $pay_type_id )
	{

		if( $pay_type_id != '' ){
		
			self::$sales->where( 'pay_type_id', '=' ,$pay_type_id );

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



	private static function generatePercentClearedPaymentCondition( $type , $value )
	{ 
		$sales = \Sale::all();

		$salesInPercent = [];

		foreach($sales as $k => $sale)
		{
		
			$percent = SaleRepo::getPercentClearedPayment($sale);

			$inPercent = false;

			switch($type)
			{
				case '>=':
					$inPercent = ($percent >= $value);
					break;
				case '==':
					$inPercent = ($percent == $value);
					break;
				case '<=':
					$inPercent = ($percent <= $value);
					break;
			}

			if($inPercent)
			{
				$salesInPercent[] = $sale->id;
			}

		}

		if(!empty($salesInPercent))
		{
			self::$sales
					->whereIn( 'id', $salesInPercent );

		}
		
			

	}



	private static function paginate( $offset , $perPage )
	{

		self::$sales->skip($offset)
					   ->take($perPage);

	}

	static function getClearedPayment( $sale )
	{
		if($sale->sale_type != 'apartado')
		{
			return $sale->subtotal;
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

	static function getRemainingPayment( $sale )
	{
		
		$clearedPayment = self::getClearedPayment($sale);

		$total = $sale->subtotal;

		return $total - $clearedPayment;

	}

	static function getPercentClearedPayment( $sale )
	{
		$clearedPayment = self::getClearedPayment($sale);

		$total = ( $sale->subtotal > 0 ) ? $sale->subtotal : 1;

		$percentClearedPayment = ($clearedPayment * 100) / ( $total ) ;

		$percentClearedPayment = number_format($percentClearedPayment, 2);

		return $percentClearedPayment;
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

        $whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId))
            self::$sales->whereIn( 'store_id' , $whereStoreId);

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

}