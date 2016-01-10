<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class SalePaymentRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $sale_payments;

	public function getModel()
    {
        return new SalePayment;
    }

	static function all(){

		return \SalePayment::all();
		
	}

	

	static function getByRange($init , $end , $groupBy)
	{
		$initDate = date('Y-m-d' , $init).' 00:00:00';

		$endDate = date('Y-m-d' , $end).' 23:59:59';
        
		$daysRange = [];

		$day = $init;

		$field;

		switch($groupBy){
			case 'day':
				$field = 'day';
				break;
			case 'week':
				$field = 'week';
				break;
			case 'month':
				$field = 'month';
				break;
			default:
				$field = 'day';
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

		self::$sale_payments = \SalePayment::with(['user']);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId)) {
            self::$sale_payments->whereIn('employee_id', function ($query) use ($whereUserId) {

                $query->select(\DB::raw('id'))
                    ->from('employees')
                    ->whereIn('employees.users_id', $whereUserId);

            });

        }

        $whereStoreId = \ACLFilter::generateStoreCondition();

        self::$sale_payments->whereIn('sale_id' , function($query) use ($whereStoreId) {

								$query->select(\DB::raw('id'))
									  ->from('sales')
									  ->whereIn('store_id' , $whereStoreId);

							});

		//self::generateSaleTypeCondition( 'contado');

		self::generateDateRangeCondition( $initDate , $endDate);

		$sale_payments = self::$sale_payments->get();

		$salePaymentsByRange = [];

		

		foreach($sale_payments as $k => $sale_payment)
		{

			if(!isset($salePaymentsByRange[$sale_payment[$field]]))
			{
			
				$salePaymentsByRange[$sale_payment[$field]] = 0;
			
			}

			$salePaymentsByRange[$sale_payment[$field]] += $sale_payment->total;

		}

		//$salePaymentsByRange = $salePaymentsByRange + $daysRange;

		//ksort($salePaymentsByRange);

		return $salePaymentsByRange;

	}

	private static function generateDateRangeCondition( $initDate , $endDate )
	{

		self::$sale_payments
				->where('created_at' , '>=' , $initDate)
				->where('created_at' , '<=' , $endDate);

	}

}