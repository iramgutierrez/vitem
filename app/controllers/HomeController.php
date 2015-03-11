<?php

use Vitem\WebServices\ListsWebServices as ListsAPI;

class HomeController extends BaseController {

	protected $ListsAPI;

	public function __construct(ListsAPI $ListsAPI)
	{
		$this->ListsAPI = $ListsAPI;
	}



	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function index()
	{

		return View::make( 	'login' );

	}

	public function dashboard()
	{
		return View::make('dashboard');
	}

	public function API( $method = 'all')
	{

		return $this->ListsAPI->$method();

	}
}
