<?php

use Vitem\Repositories\DevolutionRepo;
use Vitem\Managers\DevolutionManager;
use Vitem\WebServices\DevolutionWebServices as DevolutionAPI;

class DevolutionsController extends \BaseController {

	protected $api;

	public function __construct(DevolutionAPI $DevolutionAPI)
	{
		$this->api = $DevolutionAPI;

		$this->beforeFilter('ACL:Devolution,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Devolution,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Devolution,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Devolution,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Devolution,Delete', [ 'only' => 'destroy' ] );

	}

	/**
	 * Display a listing of the resource.
	 * GET /devolutions
	 *
	 * @return Response
	 */

	public function index()
	{

		$filtersDevolutionDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];

		return View::make('devolutions/index' , compact('filtersDevolutionDate'));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /devolutions/create
	 *
	 * @return Response
	 */
	public function create($supplier_id = false , $product_id = false)
	{
		$statuses = [
			1 => 'Solicitado',
			2 => 'Devuelto'
		];

		return View::make('devolutions/create', compact( 'statuses' , 'supplier_id' , 'product_id'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /devolutions
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();

		$createDevolution = new DevolutionManager( $data );

        $response = $createDevolution->save();

        if($response['success'])
        {
        	Session::flash('success' , 'La devolución se ha guardado correctamente.');

            return Redirect::route('devolutions.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /devolutions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$devolution =  DevolutionRepo::with(['products' , 'supplier'])->find($id);

		if(!$devolution)
		{
			Session::flash('error' , 'La devolución no existe.');

        	return Redirect::route('devolutions.index');
		}

		return View::make('devolutions/show', compact('devolution'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /devolutions/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$devolution =  Devolution::with('products')->find($id);

		if(!$devolution)
		{
			Session::flash('error' , 'La devolución no existe.');

        	return Redirect::route('devolutions.index');
		}

		$statuses = [
			1 => 'Solicitado',
			2 => 'Devuelto'
		];

		return View::make('devolutions/edit')->withDevolution($devolution)->withStatuses($statuses);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /devolutions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$devolution =  Devolution::find($id);

		if(!$devolution)
		{
			Session::flash('error' , 'La devolución no existe.');

        	return Redirect::route('devolutions.index');
		}

		$data = Input::all();

        $data['id'] = $id;


		$updateDevolution = new DevolutionManager( $data );

        $response = $updateDevolution->update();

        if($response['success'])
        {
        	Session::flash('success' , 'La devolución se ha actualizado correctamente.');

            return Redirect::route('devolutions.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /devolutions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::all();

		$data['id'] = (int) $id;

		$devolution = Devolution::find($id);

		if(!$devolution)
		{
			Session::flash('error' , 'La devolución especificada no existe.');

        	return Redirect::route('devolutions.index');
		}

		$deleteDevolution = new DevolutionManager( $data );

        $response = $deleteDevolution->delete();

        if($response)
        {
        	Session::flash('success' , 'La devolucuón se ha eliminado correctamente.');

            return Redirect::route('devolutions.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el pedido.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}


	public function API( $method = 'all')
	{

		return $this->api->$method();

	}

}