<?php

use Vitem\Repositories\ProductRepo;
use Vitem\Managers\ProductManager;
use Vitem\WebServices\ProductWebServices as ProductAPI;

class ProductsController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Product,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Product,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Product,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Product,Create,true', ['only' => [ 'image_ajax' ] ]);

		$this->beforeFilter('ACL:Product,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Product,Delete', [ 'only' => 'destroy' ] );
		
	}

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

		$stores = Store::all();

		return View::make('products/create' , compact('stores'));
		
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

		if (Request::ajax()){

			return Response::json($response , 200);

		}
		else
		{

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


	}

	public function image_ajax()
	{

		$data = Input::all();

		$createImageProduct = new ProductManager( $data );

		$response = $createImageProduct->saveImage();

		return Response::json($response,200);

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
		$product =  ProductRepo::with(['Sales' , 'Supplier' ])->find($id)->toArray();

		$sale_types = [
			'apartado' => 'Apartado',
			'contado' => 'Contado'
		];

		$pay_types = [
			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
		];

		$filtersSaleDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}
		
		return View::make('products/show', compact('product', 'sale_types' , 'pay_types' , 'filtersSaleDate'));
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
		$product =  Product::with(['stores'])->find($id);

		$stores = Store::all();

		$current_store = false;

		if(Auth::user()->role->level_id >= 3)
		{

			if(Session::has('current_store'))
			{
				$current_store = Session::get('current_store');
			}
		}
		else
		{
			$current_store = Auth::user()->store->toArray();

		}

		//$current_store = (Session::has('current_store')) ? Session::get('current_store') : false;

		if($current_store)
		{
			$current_store['quantity'] = 0;
		}

		foreach($stores as $ks => $store)
		{
			$stores[$ks]->quantity = 0;

			if(!empty($product->stores))
			{

				foreach($product->stores as $pk => $pstore)
				{

					if($store->id == $pstore->id)
					{
						$stores[$ks]->quantity = $pstore->pivot->quantity;
					}

					if(!empty($current_store['id']) && $current_store['id'] == $pstore->id)
					{

						$current_store['quantity'] = $pstore->pivot->quantity;

					}

				}

			}

		}

		if(!$product)
		{
			Session::flash('error' , 'El producto no existe.');

        	return Redirect::route('products.index');
		}
		
		return View::make('products/edit' , compact('stores' , 'current_store') )->withProduct($product);
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