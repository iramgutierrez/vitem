<?php namespace Vitem\WebServices;

use Vitem\Managers\ClientManager;
use Vitem\Managers\DestinationManager;
use Vitem\Managers\SaleManager;



class POSPostWebServices extends BaseWebServices {

	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function storeClient()
	{
		$clientData = \Input::all();

		$createClient = new ClientManager( $clientData );

        $response = $createClient->save();

		return \Response::json($response , 200);
	}
	public function storeDestination()
	{
		$data = \Input::all();

		$createDestination = new DestinationManager( $data );

        $response = $createDestination->save();

        return \Response::json($response , 200);

	}

	public function login()
	{
        $data = \Input::only('username', 'password');

        $credentials = ['username' => $data['username'], 'password' => $data['password']];

        $response = [];

        if(\Auth::validate($credentials)){

			$user = \User::with('employee' , 'role')->whereUsername($credentials['username'])->first();

            if(!empty($user->role) && $user->role->slug == 'vendedor')
            {
                $response['success'] = true;

                $response['user'] = $user;

            }
            else
            {
                $response['success'] = false;

                $response['error'] = 'Solo pueden acceder usuarios vendedores.';
            }

        }else
        {
        	$response['success'] = false;

            $response['error'] = 'Login incorrecto';
        }

        return \Response::json($response , 200);

	}

	public function verifyLogin()
	{
        $credentials = \Input::only('username', 'password');

        $match = \Auth::validate($credentials);

        if($match)
        {
            $response = [
                'success' => true,
            ];
        }
        else
        {
            $response = [
                'success' => false,
                'message' => 'Not match'
            ];
        }

        return \Response::json($response , 200);
	}

    public function storeSale()
    {
        $data = \Input::all();

        $createSale = new SaleManager( $data );

        $response = $createSale->save();

        if($response['success'])
        {

            return \Response::json(['success' => true],200);
        }
        else
        {

            return \Response::json(['errors' => $response['errors']],401);

        }
    }

	private function isEqual($str1, $str2)
	{
	    $n1 = strlen($str1);
	    if (strlen($str2) != $n1) {
	        return false;
	    }
	    for ($i = 0, $diff = 0; $i != $n1; ++$i) {
	        $diff |= ord($str1[$i]) ^ ord($str2[$i]);
	    }
	    return !$diff;
	}
}