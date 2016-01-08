<?php namespace Vitem\WebServices;

use Vitem\Repositories\ProductRepo;
use Vitem\Repositories\PackRepo;
use Vitem\Repositories\ClientRepo;
use Vitem\Repositories\DestinationRepo;
use Vitem\Repositories\UserRepo;


class POSWebServices extends BaseWebServices {

	protected $product;

	protected $pack;

	protected $client;

	protected $destination;

    protected $user;

	public function __construct(ProductRepo $ProductRepo , PackRepo $PackRepo , ClientRepo $ClientRepo, DestinationRepo $DestinationRepo, UserRepo $UserRepo)
	{
		$this->product = $ProductRepo;

		$this->pack = $PackRepo;

		$this->client = $ClientRepo;

		$this->destination = $DestinationRepo;

        $this->user = $UserRepo;
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

		//$store_id = \Input::get('store_id');

		$products = $this->product->search($find );

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

    public function searchDriver()
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

        $store_id = (!empty($_GET['store_id'])) ? $_GET['store_id'] : false;

        $sellers = \User::with(['Employee' , 'store']);

        $fields = ['name' , 'id'];

        $sellers = $sellers->where(
            function($query) use ($find , $fields) {

                foreach($fields as $field){

                    $query->orWhere($field, 'LIKE' , '%' . $find . '%' );

                }

            }

        );

        $sellers = $sellers->where('role_id' ,function($query)
        {
            $query->select(\DB::raw('id'))
                ->from('roles')
                ->whereRaw('roles.slug = "chofer"');

        })->get();

        return \Response::json($sellers);

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

		$product = $this->product->getByKey($key);

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

	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function store()
	{
		$clientData = Input::all();

		$createClient = new ClientManager( $clientData );

        $response = $createClient->save();

		if (Request::ajax()){

			return Response::json($response , 200);

		}
		else {

			if ($response['success']) {
				Session::flash('success', 'El cliente se ha guardado correctamente.');

				return Redirect::route('clients.index');
			} else {

				Session::flash('error', 'Existen errores en el formulario.');

				return Redirect::back()->withErrors($response['errors'])->withInput();

			}

		}
	}
	public function clientCheckEmail()
	{

		$email = (\Input::has('email')) ? \Input::get('email') : false;

		$client = \Client::where('email' , $email)->first();

		if($client)
		{

			return 0;

		}
		else
		{

			return "true";
		}

	}


    public function getAccessToken()
    {


        return \Response::json(\Authorizer::issueAccessToken());

    }

}