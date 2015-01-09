<?php namespace Vitem\WebServices;


class SupplierWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Supplier::get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$supplier = \Supplier::where('id' , $id)->first();

		return \Response::json($supplier);

	}
}