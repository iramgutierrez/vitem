<?php namespace Vitem\WebServices;

use Vitem\Repositories\SupplierRepo;


class SupplierWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(SupplierRepo::with(['products'])->get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$supplier = SupplierRepo::with(['products'])->where('id' , $id)->first();

		return \Response::json($supplier);

	}

	static function checkEmail()
	{

		$email = (\Input::has('supplier.email')) ? \Input::get('supplier.email') : false;

		$supplier = \Supplier::where('email' , $email)->first();

		if($supplier)
		{

			return 0;

		}
		else
		{

			return "true";
		}

	}
}