<?php

use Vitem\Managers\ColorManager;
use Vitem\WebServices\ColorWebServices as ColorAPI;

class ColorsController extends \BaseController {

	protected $ColorAPI;

	public function __construct(ColorAPI $ColorAPI)
	{
		$this->ColorAPI = $ColorAPI;

		$this->beforeFilter('ACL:Color,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Color,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Color,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Color,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Color,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('colors/index');
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
		
		$colorData = Input::all();  

		$createColor = new ColorManager( $colorData );

        $response = $createColor->save();

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
		$color = Color::find($id);

		if(!$color)
		{
			Session::flash('error' , 'El color no existe.');

        	return Redirect::route('colors.index');
		}

		Color::destroy($id);

	    Session::flash('success' , 'El color se ha eliminado correctamente.');

        return Redirect::route('colors.index');
	}

	public function API( $method = 'all')
	{

		return $this->ColorAPI->$method();

	}

}