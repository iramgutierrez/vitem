<?php

use Vitem\Managers\ClientManager;
use Vitem\WebServices\ClientWebServices as ClientAPI;

class ClientsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{
		$client_types = ClientType::lists('name' , 'id' );

		$statuses = [
			0 => 'Inactivo' ,
			1 => 'Activo'
		];

		$filtersEntryDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];

		return View::make('clients/index', compact('client_types' , 'statuses' , 'filtersEntryDate'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /clients/create
	 *
	 * @return Response
	 */
	public function create()
	{
		

		$client_types = ClientType::lists('name' , 'id' );
		
		return View::make('clients/create', compact('client_types'));

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function store()
	{
		$clientData = Input::all();   

		$createClient = new ClientManager( $clientData );

        $response = $createClient->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El cliente se ha guardado correctamente.');

            return Redirect::route('clients.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client =  Client::find($id);

		if(!$client)
		{
			Session::flash('error' , 'El cliente no existe.');

        	return Redirect::route('clients.index');
		}

		$client_types = ClientType::lists('name' , 'id' );
		
		return View::make('clients/show', compact('client_types' , 'client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /clients/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client =  Client::find($id);

		if(!$client)
		{
			Session::flash('error' , 'El cliente no existe.');

        	return Redirect::route('clients.index');
		}

		$client_types = ClientType::lists('name' , 'id' );
		
		return View::make('clients/edit', compact('client_types'))->withClient($client);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$client =  Client::find($id);

		if(!$client)
		{
			Session::flash('error' , 'El cliente no existe.');

        	return Redirect::route('clients.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;


		$updateClient = new ClientManager( $data );

        $response = $updateClient->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El cliente se ha actualizado correctamente.');

            return Redirect::route('clients.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$client = Client::find($id);

		if(!$client)
		{
			Session::flash('error' , 'El cliente no existe.');

        	return Redirect::route('clients.index');
		}

		Client::destroy($id);

	    Session::flash('success' , 'El cliente se ha eliminado correctamente.');

        return Redirect::route('clients.index');
	}

	public function API( $method = 'all')
	{

		return ClientAPI::{$method}();

	}

}