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

		if(Auth::user()->role->level_id < 2)
		{
			Session::reflash();

			return Redirect::route('users.show' , [Auth::user()->id]);
		}

		$stores = Store::lists('name' , 'id' );

		$stores = $stores + [0 => 'Almacen'];

		sort($stores);

		return View::make('dashboard' , compact('stores'));
	}

	public function API( $method = 'all')
	{

		return $this->ListsAPI->$method();

	}
}
