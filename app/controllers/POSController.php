<?php

use Vitem\WebServices\POSWebServices as POSAPI;
use Vitem\WebServices\POSPostWebServices as POSPostAPI;

class POSController extends \BaseController {

	protected $POSAPI;

	public function __construct(POSAPI $POSAPI , POSPostAPI $POSPostAPI)
	{
		$this->POSAPI = $POSAPI;

		$this->POSPostAPI = $POSPostAPI;

	}

	public function API( $method = false)
	{
		if($method)
		{

			header('Access-Control-Allow-Origin: *');

			return $this->POSAPI->$method();
		}

		return Response::make('No se indico ningún método.');

	}

	public function APIPost( $method = false)
	{
		if($method)
		{
            header('Access-Control-Allow-Origin: *');

			return $this->POSPostAPI->$method();
		}

		return Response::make('No se indico ningún método.');

	}

}