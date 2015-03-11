<?php

use Vitem\Repositories\PackRepo;
use Vitem\Managers\PackManager;
use Vitem\WebServices\PackWebServices as PackAPI;

class PacksController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Pack,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Pack,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Pack,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Pack,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Pack,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /packs
	 *
	 * @return Response
	 */
	public function index()
	{
		$statuses = [
			'0' => 'No disponible',
			'1' => 'Disponible'
		];


		return View::make('packs/index',compact('statuses'));
	
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /packs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('packs/create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /packs
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createPack = new PackManager( $data );		

        $response = $createPack->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El paquete se ha guardado correctamente.');

            return Redirect::route('packs.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /packs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pack =  PackRepo::with(['products'])->find($id);

		if(!$pack)
		{
			Session::flash('error' , 'El paquete no existe.');

        	return Redirect::route('packs.index');
		}
		
		return View::make('packs/show', compact('pack'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /packs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pack =  Pack::with('products')->find($id);

		if(!$pack)
		{
			Session::flash('error' , 'El paquete no existe.');

        	return Redirect::route('packs.index');
		}
		
		return View::make('packs/edit')->withPack($pack);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /packs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pack =  Pack::with('products')->find($id);

		if(!$pack)
		{
			Session::flash('error' , 'El paquete no existe.');

        	return Redirect::route('packs.index');
		}

		$data = Input::all(); 

        $data['id'] = (int) $id;


		$updatePack = new PackManager( $data );

        $response = $updatePack->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El paquete se ha actualizado correctamente.');

            return Redirect::route('packs.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /packs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pack = Pack::find($id);

		if(!$pack)
		{
			Session::flash('error' , 'El paquete no existe.');

        	return Redirect::route('packs.index');
		}

		$pack->products()->detach();

		Pack::destroy($id);

	    Session::flash('success' , 'El paquete se ha eliminado correctamente.');

        return Redirect::route('packs.index');
	}


	public function API( $method = 'all')
	{

		return PackAPI::{$method}();

	}

}