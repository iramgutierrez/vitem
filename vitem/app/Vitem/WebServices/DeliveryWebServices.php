<?php namespace Vitem\WebServices;

//use Vitem\Repositories\CommissionRepo;


class DeliveryWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Delivery::get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$delivery = \Delivery::with(['employee.user', 'sale.employee.user' , 'destination'])
						 ->where('id' , $id)->first();

		return \Response::json($delivery);

	}

	static function getUpcoming()
	{
		$date = (isset($_GET['date'])) ? $_GET['date'] : time();

		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;

		$date = date('Y-m-d' , $date);

		$delivery = \Delivery::with(['employee.user', 'sale.employee.user' , 'destination'])
						 		->where('delivery_date' , '>=' , $date)
						 		->take($limit)	
						 		->orderBy('delivery_date' ,'asc')
						 		->get();

		return \Response::json($delivery);

	}
}