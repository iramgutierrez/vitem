<?php

use Vitem\Managers\PayTypeManager;
use Vitem\WebServices\PayTypeWebServices as PayTypeAPI;

class PayTypesController extends \BaseController {

	protected $PayTypeAPI;

	public function __construct(PayTypeAPI $PayTypeAPI)
	{
		$this->PayTypeAPI = $PayTypeAPI;

		$this->beforeFilter('ACL:PayType,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:PayType,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:PayType,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:PayType,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:PayType,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('pay_types/index' , compact('types'));
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
		
		$payTypeData = Input::all();  

		$createPayType = new PayTypeManager( $payTypeData );

        $response = $createPayType->save();

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
		$pay_type = PayType::find($id);

		if(!$pay_type)
		{
			Session::flash('error' , 'La forma de pago no existe.');

        	return Redirect::route('pay_types.index');
		}

		PayType::destroy($id);

	    Session::flash('success' , 'La forma de pago se ha eliminado correctamente.');

        return Redirect::route('pay_types.index');
	}

	public function API( $method = 'all')
	{

		return $this->PayTypeAPI->$method();

	}

}