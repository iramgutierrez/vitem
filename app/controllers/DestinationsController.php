<?php

use Vitem\Managers\DestinationManager;
use Vitem\WebServices\DestinationWebServices as DestinationAPI;


class DestinationsController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Destination,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Destination,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Destination,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Destination,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Destination,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /destinations
	 *
	 * @return Response
	 */
	public function index()
	{
		$types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];

		return View::make('destinations/index' , compact('types'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /destinations/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];

		return View::make('destinations/create', compact('types'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /destinations
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createDestination = new DestinationManager( $data );		

        $response = $createDestination->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El destino se ha guardado correctamente.');

            return Redirect::route('destinations.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');
            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /destinations/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$destination =  Destination::find($id);

		if(!$destination)
		{
			Session::flash('error' , 'El destino no existe.');

        	return Redirect::route('destinations.index');
		}
		
		return View::make('destinations/show', compact('destination'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /destinations/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$destination =  Destination::find($id);

		if(!$destination)
		{
			Session::flash('error' , 'El destino no existe.');

        	return Redirect::route('destinations.index');
		}

		$types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];
		
		return View::make('destinations/edit')->withDestination($destination)->withTypes($types);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /destinations/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$destination =  Destination::find($id);

		if(!$destination)
		{
			Session::flash('error' , 'El destino no existe.');

        	return Redirect::route('destinations.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;


		$updateDestination = new DestinationManager( $data );

        $response = $updateDestination->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El destino se ha actualizado correctamente.');

            return Redirect::route('destinations.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /destinations/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$destination = Destination::find($id);

		if(!$destination)
		{
			Session::flash('error' , 'El destino no existe.');

        	return Redirect::route('destinations.index');
		}

		Destination::destroy($id);

	    Session::flash('success' , 'El destino se ha eliminado correctamente.');

        return Redirect::route('destinations.index');

	}

	public function API($method = 'all')
	{
		
		return DestinationAPI::$method();

	}

}