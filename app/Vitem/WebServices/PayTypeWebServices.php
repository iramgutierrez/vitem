<?php namespace Vitem\WebServices;

//use Vitem\Repositories\PackRepo;


class PayTypeWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\PayType::all());

	}
}