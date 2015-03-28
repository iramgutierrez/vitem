<?php namespace Vitem\WebServices;

use Vitem\Repositories\DeliveryRepo;


class DeliveryWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(DeliveryRepo::all());
		
	}

	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$destinations = [
		
			'data' => DeliveryRepo::findByPage($page , $perPage , $find ),
			'total' => DeliveryRepo::countFind($find )
		];

		return \Response::json($destinations);
	}

	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$delivery = DeliveryRepo::with(['employee.user' , 'destination' , 'sale' , 'destination']);

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$delivery = $delivery->whereIn('employee_id' , $usersPermitted);
		}		

        $whereStoreId = \ACLFilter::generateStoreCondition();

        $delivery = $delivery->whereIn('sale_id' , function($query) use ($whereStoreId) {

								$query->select(\DB::raw('id'))
									  ->from('sales')
									  ->whereIn('store_id' , $whereStoreId);

							});

		$delivery = $delivery->where('id' , $id)->first();

		return \Response::json($delivery);

	}

	static function getUpcoming()
	{
		$date = (isset($_GET['date'])) ? $_GET['date'] : time();

		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

		$date = date('Y-m-d' , $date);

		$delivery = DeliveryRepo::with(['employee.user', 'destination' , 'sale.store', 'destination']);

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$delivery = $delivery->whereIn('employee_id' , $usersPermitted);
		}	

        $whereStoreId = \ACLFilter::generateStoreCondition();

        $delivery = $delivery->whereIn('sale_id' , function($query) use ($whereStoreId) {

								$query->select(\DB::raw('id'))
									  ->from('sales')
									  ->whereIn('store_id' , $whereStoreId);

							});

		$delivery = $delivery
							->where('delivery_date' , '>=' , $date)							
						 	->take($limit)	
						 	->orderBy('delivery_date' ,'asc')
						 	->get();

		return \Response::json($delivery);

	}
	
}