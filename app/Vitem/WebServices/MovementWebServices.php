<?php namespace Vitem\WebServices;

use Vitem\Repositories\MovementRepo;


class MovementWebServices extends BaseWebServices {

	protected $movement;

	public function __construct(MovementRepo $MovementRepo)
	{

		$this->movement = $MovementRepo;

	}


	/*public function getModel()
	{
		return new User;
	}*/

	public function all()
	{
		$movements = \Movement::with([
				'user',
				'store'
			]);

		$whereStoreId = \ACLFilter::generateStoreCondition();

		if(count($whereStoreId) < \Store::count() )
        {

            $movements = $movements->whereIn( 'store_id' , $whereStoreId);

        }

        $movements = $movements->get();

		return \Response::json($movements);
	}

	static function findReport()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$initDate = (!empty($_GET['initDate'])) ? $_GET['initDate'] : false;

		$endDate = (!empty($_GET['endDate'])) ? $_GET['endDate'] : false;

		$movements = [

			'data' => MovementRepo::findByPageReport($page , $perPage , $initDate , $endDate ),
			'total' => MovementRepo::countFindReport($initDate , $endDate)
		];

		return \Response::json($movements);
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

		$canReadSalePayments = PermissionRepo::checkAuth('SalePayment', 'Read' );

		if($showSalePayments == 'true' && $canReadSalePayments){
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
}