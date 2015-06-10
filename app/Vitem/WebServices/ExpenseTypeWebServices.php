<?php namespace Vitem\WebServices;

//use Vitem\Repositories\PackRepo;


class ExpenseTypeWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\ExpenseType::all());

	}
}