<?php

use Vitem\WebServices\MovementWebServices as MovementAPI;

class MovementsController extends \BaseController {

	protected $api;

	public function __construct(MovementAPI $MovementAPI)
	{

		$this->beforeFilter('ACL:Movement,Read', ['only' => [ 'API' ] ] );

		$this->api = $MovementAPI;

	}

	public function API( $method = 'all')
	{

		return $this->api->$method();

	}

}