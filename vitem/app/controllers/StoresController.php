<?php

use Vitem\Repositories\StoreRepo as StoreRepo;


class StoresController extends \BaseController {

	//protected $Store;


	public function __construct(/*Store $Store*/)
	{

		$this->beforeFilter('ACL:Store,Read', array('only' => 'index'));

		//$this->Store = $Store;

	}

	/**
	 * Display a listing of the resource.
	 * GET /stores
	 *
	 * @return Response
	 */
	public function index()
	{

		/*$stores = Store::find('1');

		dd($stores);*/

		$storesRepo = StoreRepo::find2('1');

		dd($storesRepo);

		return View::make('stores/index');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /stores/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /stores
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /stores/{id}
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
	 * GET /stores/{id}/edit
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
	 * PUT /stores/{id}
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
	 * DELETE /stores/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}