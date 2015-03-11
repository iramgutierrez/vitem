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

	static function checkEmail()
	{

		$email = (\Input::has('email')) ? \Input::get('email') : false;

		$client = \Client::where('email' , $email)->first();

		if($client)
		{

			return 0;

		}
		else
		{

			return "true";
		}

	}



	static function getClientById()
	{

		$id = (!empty($_GET['id'])) ? $_GET['id'] : false;

		$client = \Client::where( 'id' , $id)->first();

		return \Response::json($client);

	}
}