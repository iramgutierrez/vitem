<?php

use Vitem\Repositories\ExpenseRepo;
use Vitem\Managers\ExpenseManager;
use Vitem\WebServices\ExpenseWebServices as ExpenseAPI;

class ExpensesController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Expense,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Expense,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Expense,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Expense,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Expense,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /expenses
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$types = ExpenseType::lists('name' ,'id');
		
		return View::make('expenses/index' , compact('types'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /expenses/create
	 *
	 * @return Response
	 */
	public function create()
	{

		$types = ExpenseType::lists('name' ,'id');

		$stores = Store::lists('name' , 'id' );
		
		return View::make('expenses/create', compact('types' , 'stores'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /expenses
	 *
	 * @return Response
	 */
	public function store()
	{
		$expenseData = Input::all();   

		$createExpense = new ExpenseManager( $expenseData );

        $response = $createExpense->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El gasto se ha guardado correctamente.');

            return Redirect::route('expenses.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /expenses/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$expense =  ExpenseRepo::
						with(['user' , 'employee.user' , 'expense_type'])
						->find($id);

		if(!$expense)
		{
			Session::flash('error' , 'El gasto especificado no existe.');

        	return Redirect::route('expenses.index');
		}
		
		return View::make('expenses/show', compact('expense'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /expenses/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$expense =  Expense::find($id);

		if(!$expense)
		{
			Session::flash('error' , 'El gasto no existe.');

        	return Redirect::route('expenses.index');
		}

		$types = ExpenseType::lists('name' ,'id');

		$stores = Store::lists('name' , 'id' );
		
		return View::make('expenses/edit' , compact('stores'))->withExpense($expense)->withTypes($types);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /expenses/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$expense =  Expense::find($id);

		if(!$expense)
		{
			Session::flash('error' , 'El gasto especificado no existe.');

        	return Redirect::route('expenses.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;


		$updateExpense = new ExpenseManager( $data );

        $response = $updateExpense->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El gasto se ha actualizado correctamente.');

            return Redirect::route('expenses.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /expenses/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$data = Input::all();

		$data['id'] = (int) $id;

		 $expense = Expense::find($id);

		if(!$expense)
		{
			Session::flash('error' , 'El gasto especificada no existe.');

        	return Redirect::route('sales.index');
		}

		$deleteExpense = new ExpenseManager( $data );		

        $response = $deleteExpense->delete();

        if($response)
        {
        	Session::flash('success' , 'El gasto se ha eliminado correctamente.');

            return Redirect::route('expenses.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el gasto.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
        
	}

	public function API($method = 'all')
	{
		
		return ExpenseAPI::{$method}();

	}

}