<?php


class AddressesController extends \BaseController {

	public function __construct()
	{

	}

	public function create($entity , $entity_id)
	{
		$client_types = ClientType::lists('name' , 'id' );

		return View::make('addresses/create', compact('client_types'));
	}

}