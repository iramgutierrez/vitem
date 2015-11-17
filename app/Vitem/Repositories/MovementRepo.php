<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class MovementRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $movements;

	public function getModel()
	{
		return new \Movement;
	}

	static function all(){

		return \Movement::all();

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

	static function findByPageReport($page , $perPage , $initDate , $endDate , $find , $storeId , $type , $entityType , $flow)
	{

		$offset = ($page - 1 ) * $perPage;

		self::$movements = \Movement::with([
										'user',
										'store'
									]);

		self::generateDateRangeCondition( $initDate , $endDate);

		self::generateStoreIdCondition( $storeId);

		self::generateLikeCondition( $find , ['id' , 'entity_id']);

		self::generateTypeCondition( $type);

		self::generateEntityTypeCondition( $entityType);

		self::generateFlowCondition( $flow);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$movements->whereIn( 'user_id' , $whereUserId);

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId) < \Store::count() )
        {
            self::$movements->whereIn( 'store_id' , $whereStoreId);
        }

		return self::$movements->get();

	}

	static function countFindReport($initDate , $endDate ,$find, $storeId , $type , $entityType , $flow)
	{



		self::$movements = \Movement::with([
										'user',
										'store'
									]);

		self::generateDateRangeCondition( $initDate , $endDate);

		self::generateLikeCondition( $find , ['id' , 'entity_id']);

		self::generateStoreIdCondition( $storeId);

		self::generateTypeCondition( $type);

		self::generateEntityTypeCondition( $entityType);

		self::generateFlowCondition( $flow);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$movements->whereIn( 'user_id' , $whereUserId);

		$whereStoreId = \ACLFilter::generateStoreCondition();

        if(count($whereStoreId) < \Store::count() )
            self::$movements->whereIn( 'store_id' , $whereStoreId);


		return self::$movements->count();

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

	private static function generateDateRangeCondition( $initDate , $endDate )
	{

		if( $initDate && $endDate){

			self::$movements
					->where( 'date', '>=' ,$initDate )
					->where( 'date', '<=' ,$endDate );

		}

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$movements->where(
							function($query) use ($sentence , $fields) {

								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

								$query->orWhereIn('user_id' ,function($query) use ($sentence)
								{
									$query->select(\DB::raw('id'))
										->from('users')
										->whereRaw('users.name LIKE "%' . $sentence . '%"');
								});

							}

						);

		}

	}

	private static function generateStoreIdCondition( $storeId)
	{

		if( $storeId){

			self::$movements
					->where( 'store_id',$storeId );

		}

	}

	private static function generateTypeCondition( $type)
	{

		if( $type){

			self::$movements
					->where( 'type',$type );

		}

	}

	private static function generateEntityTypeCondition( $entityType)
	{

		if( $entityType){

			self::$movements
					->where( 'entity',$entityType );

		}

	}

	private static function generateFlowCondition( $flow)
	{

		if( $flow){

			if($flow == 'in')
			{
				self::$movements
					->where( 'total', '>= ', 0 );
			}
			else if($flow == 'out')
			{
				self::$movements
					->where( 'total' , '<' , 0 );
			}


		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$movements->skip($offset)
					   ->take($perPage);

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

	static function with($entities )
	{

		return \Sale::with(parent::with($entities));


	}

}