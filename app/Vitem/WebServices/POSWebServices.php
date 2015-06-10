<?php namespace Vitem\WebServices;

use Vitem\Repositories\ProductRepo;
use Vitem\Repositories\PackRepo;
use Vitem\Repositories\ClientRepo;
use Vitem\Repositories\DestinationRepo;


class POSWebServices extends BaseWebServices {

	protected $product;

	protected $pack;

	protected $client;

	protected $destination;

	public function __construct(ProductRepo $ProductRepo , PackRepo $PackRepo , ClientRepo $ClientRepo, DestinationRepo $DestinationRepo)
	{
		$this->product = $ProductRepo;

		$this->pack = $PackRepo;

		$this->client = $ClientRepo;

		$this->destination = $DestinationRepo;
	}

	public function getAllPayTypes()
	{

		$response = \Response::json(\PayType::all());

		return $response;

	}

	public function getAllSaleTypes()
	{
		$sale_types = [
			'apartado' => 'Apartado',
			'contado' => 'Contado'
		];

		$response = \Response::json($sale_types);

		return $response;

	}

	public function searchProducts()
	{

		if(!\Input::has('find'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$find = \Input::get('find');

		$store_id = \Input::get('store_id');

		$products = $this->product->search($find , $store_id);

		return \Response::json($products);

	}

	public function searchPacks()
	{

		if(!\Input::has('find'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$find = \Input::get('find');

		$store_id = \Input::get('store_id');

		$products = $this->pack->search($find , $store_id);

		return \Response::json($products);

	}

	public function searchClient()
	{

		if(!\Input::has('find'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$find = \Input::get('find');

		$clients = $this->client->search($find);

		return \Response::json($clients);

	}

	public function searchDestination()
	{

		if(!\Input::has('find'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$find = \Input::get('find');

		$destinations = $this->destination->search($find);

		return \Response::json($destinations);

	}

	public function getProduct()
	{

		if(!\Input::has('key'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$key = \Input::get('key');

		$store_id = \Input::get('store_id');

		$product = $this->product->getByKeyAndStore($key , $store_id);

		return \Response::json($product);

	}

	public function getPack()
	{

		if(!\Input::has('key'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$key = \Input::get('key');

		$store_id = \Input::get('store_id');

		$product = $this->pack->getByKeyAndStore($key , $store_id);

		return \Response::json($product);

	}

	public function getClient()
	{

		if(!\Input::has('id'))
		{
			$response = [

				'success' => false,
				'message' => 'No se envio ningún parámetro de búsqueda.'

			];

			return \Response::json($response);

		}

		$id = \Input::get('id');

		$client = \Client::find($id);

		return \Response::json($client);

	}

	public function getNextSheet()
	{

		$lastSale = \Sale::limit(1)->orderBy('id' , 'desc')->first()->toArray();

		$next = $lastSale['id'] + 1;

		return \Response::make($next , 200);

	}
}