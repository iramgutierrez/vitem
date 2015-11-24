<?php

use Vitem\Managers\CatalogManager;
use Vitem\WebServices\CatalogWebServices as CatalogAPI;

class CatalogsController extends \BaseController {

	protected $CatalogAPI;

	public function __construct(CatalogAPI $CatalogAPI)
	{
		$this->CatalogAPI = $CatalogAPI;

		$this->beforeFilter('ACL:Segment,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Segment,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Segment,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Segment,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Segment,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('catalogs/index');
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
		
		$catalogData = Input::all();  

		$createCatalog = new CatalogManager( $catalogData );

        $response = $createCatalog->save();

        return Response::json($response , 200);

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
		$catalog = Catalog::find($id);

		if(!$catalog)
		{
			Session::flash('error' , 'El catálogo no existe.');

        	return Redirect::route('catalogs.index');
		}

		Catalog::destroy($id);

	    Session::flash('success' , 'El catálogo se ha eliminado correctamente.');

        return Redirect::route('catalogs.index');
	}

	public function API( $method = 'all')
	{

		return $this->CatalogAPI->$method();

	}

}