<?php namespace Vitem\WebServices;

use Vitem\Repositories\SaleRepo;
use Vitem\Repositories\SalePaymentRepo;
use Vitem\Repositories\PackRepo;


class SettingWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Setting::with('user')
									->get());
		
	}

	static function getTotalResidue()
	{
		return \Response::make(\Setting::where('key' , 'residue')->first()->value , 200);
	}

	static function getRecords()
	{	

		$limit = (!empty($_GET['limit'])) ? $_GET['limit'] : 20;

		return \Response::json(\Record::with('user')
										->take($limit)
										->orderBy('id' , 'desc')
					  				  	->get());
	}

}