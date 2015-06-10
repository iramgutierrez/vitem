<?php

use Vitem\Managers\ExpenseTypeManager;
use Vitem\WebServices\ExpenseTypeWebServices as ExpenseTypeAPI;

class ExpenseTypesController extends \BaseController {

	protected $ExpenseTypeAPI;

	public function __construct(ExpenseTypeAPI $ExpenseTypeAPI)
	{
		$this->ExpenseTypeAPI = $ExpenseTypeAPI;

		$this->beforeFilter('ACL:ExpenseType,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:ExpenseType,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:ExpenseType,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:ExpenseType,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:ExpenseType,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('expense_types/index');
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
		
		$expenseTypeData = Input::all();  

		$createExpenseType = new ExpenseTypeManager( $expenseTypeData );

        $response = $createExpenseType->save();

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
		$expense_type = ExpenseType::find($id);

		if(!$expense_type)
		{
			Session::flash('error' , 'El tipo de gasto no existe.');

        	return Redirect::route('expense_types.index');
		}

		ExpenseType::destroy($id);

	    Session::flash('success' , 'El tipo de gasto se ha eliminado correctamente.');

        return Redirect::route('expense_types.index');
	}

	public function API( $method = 'all')
	{

		return $this->ExpenseTypeAPI->$method();

	}

}