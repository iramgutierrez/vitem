<?php namespace Vitem\WebServices;

//use Vitem\Repositories\PackRepo;


class ClientTypeWebServices extends BaseWebServices {

	public function all()
	{ 
		return \Response::json(\ClientType::all());
	}
}