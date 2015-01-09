<?php namespace Vitem\WebServices;

use Vitem\Repositories\SaleRepo;
use Vitem\Repositories\SalePaymentRepo;
use Vitem\Repositories\PackRepo;


class ClientWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Client::get());
		
	}

	static function getClientsWeek()
	{
		$init = date('Y-m-d' , time() - (60*60*24*7) );

		$end = date('Y-m-d');
		
		return \Response::make(
							\Client::where('entry_date', '>=' , $init)
									->where('entry_date', '<=' , $end)
									->count() ,
							200
						);
	}
}