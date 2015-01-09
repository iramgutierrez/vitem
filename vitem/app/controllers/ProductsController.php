<?php

use Vitem\Managers\ProductManager;
use Vitem\WebServices\ProductWebServices as ProductAPI;

class ProductsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index()
	{

		$statuses = [
			'0' => 'No disponible',
			'1' => 'Disponible'
		];


		return View::make('products/index',compact('statuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{

		return View::make('products/create' );
		
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /products
	 *
	 * @return Response
	 */
	public function store()
	{
		

		$data = Input::all(); 

		$createProduct = new ProductManager( $data );

        $response = $createProduct->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El producto se ha guardado correctamente.');

            return Redirect::route('products.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput()->with(['newSupplier' => $response['newSupplier'], 'supplierSelectedId' => $response['supplierSelectedId'] ]);

        }
	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product =  Product::find($id);

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}
		
		return View::make('products/show', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /products/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product =  Product::find($id);

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}
		
		return View::make('products/edit')->withProduct($product);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$product =  Product::find($id);

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}

		$data = Input::all(); 

        $data['id'] = (int) $id;


		$updateProduct = new ProductManager( $data );

        $response = $updateProduct->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El producto se ha actualizado correctamente.');

            return Redirect::route('products.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput()->with(['newSupplier' => $response['newSupplier'], 'supplierSelectedId' => $response['supplierSelectedId'] ]);

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$product = Product::find($id);

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}

		Product::destroy($id);

	    Session::flash('success' , 'El producto se ha eliminado correctamente.');

        return Redirect::route('products.index');
	}


	public function API( $method = 'all')
	{

		return ProductAPI::{$method}();

	}

}