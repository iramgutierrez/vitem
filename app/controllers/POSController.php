<?php

use Vitem\WebServices\POSWebServices as POSAPI;

class POSController extends \BaseController {

	protected $POSAPI;

	public function __construct(POSAPI $POSAPI)
	{
		$this->POSAPI = $POSAPI;
		
	}	

	public function API( $method = false)
	{
		if($method)
		{
			header('Access-Control-Allow-Origin: http://localhost:9000');  

			return $this->POSAPI->$method();
		}

		return Response::make('No se indico ningún método.');

	}

}