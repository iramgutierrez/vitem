<?php

use Vitem\Managers\ClientTypeManager;
use Vitem\WebServices\ClientTypeWebServices as ClientTypeAPI;

class ClientTypesController extends \BaseController {

	protected $ClientTypeAPI;

	public function __construct(ClientTypeAPI $ClientTypeAPI)
	{
		$this->ClientTypeAPI = $ClientTypeAPI;

		$this->beforeFilter('ACL:ClientType,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:ClientType,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:ClientType,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:ClientType,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:ClientType,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('client_types/index' );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /paytypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /paytypes
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$clientTypeData = Input::all();  

		$createClientType = new ClientTypeManager( $clientTypeData );

        $response = $createClientType->save();

        return Response::json($response , 200);

		/*if (Request::ajax()){

			return Response::json($response , 200);

		}
		else {

			if ($response['success']) {
				Session::flash('success', 'La forma de pago se ha guardado correctamente.');

				return Redirect::route('suppliers.index');
			} else {

				Session::flash('error', 'Existen errores en el formulario.');

				return Redirect::back()->withErrors($response['errors'])->withInput();

			}

		}*/

	}

	/**
	 * Display the specified resource.
	 * GET /paytypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /paytypes/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /paytypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /paytypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$client_type = ClientType::find($id);

		if(!$client_type)
		{
			Session::flash('error' , 'El tipo de cliente no existe.');

        	return Redirect::route('client_types.index');
		}

		ClientType::destroy($id);

	    Session::flash('success' , 'El tipo de cliente se ha eliminado correctamente.');

        return Redirect::route('client_types.index');
	}

	public function API( $method = 'all')
	{

		return $this->ClientTypeAPI->$method();

	}

}