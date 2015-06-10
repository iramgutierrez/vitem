<?php namespace Vitem\WebServices;


class ListsWebServices extends BaseWebServices {

	
	public function PayType()
	{

		return \Response::json(\PayType::all());

	}
}