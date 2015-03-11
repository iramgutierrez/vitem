<?php namespace Vitem\Managers;

use Vitem\Validators\ClientValidator;


class ClientManager extends BaseManager {

    protected $client;

    
    public function save()
    {
        $clientValidator = new ClientValidator(new \Client);

        $clientData = $this->data;  
        
        $clientValid  =  $clientValidator->isValid($clientData);

        if( $clientValid )
        {
            $clientData = $this->prepareData( $clientData );

            $client = new \Client( $clientData );
            
            $client->save();

            $response = [
                'success' => true,
                'client' => $client
            ];            

        }
        else
        {
            
            $clientErrors = [];

            if($clientValidator->getErrors())
                $clientErrors = $clientValidator->getErrors()->toArray();            

            $errors =  $clientErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $clientData = $this->data;    

        $this->client = \Client::find($clientData['id']);

        $clientValidator = new ClientValidator($this->client);


        $clientData = $this->prepareData( $clientData ); 

        $clientValid  =  $clientValidator->isValid($clientData);

        

        if( $clientValid )
        {             

            $client = $this->client;

            $client->name = $clientData['name'];

            $client->email = $clientData['email'];

            $client->rfc = $clientData['rfc'];

            $client->business_name = $clientData['business_name'];

            $client->street = $clientData['street'];

            $client->outer_number = $clientData['outer_number'];

            $client->inner_number = $clientData['inner_number'];

            $client->zip_code = $clientData['zip_code'];

            $client->colony = $clientData['colony'];

            $client->city = $clientData['city'];

            $client->state = $clientData['state'];

            $client->phone = $clientData['phone'];          

            $client->client_type_id = $clientData['client_type_id'];

            $client->image_profile = $clientData['image_profile'];

            $client->entry_date = $clientData['entry_date'];

            $client->status = $clientData['status'];
            
            $client->save();

            $response = [
                'success' => true
            ];            

        }
        else
        {
            
            $clientErrors = [];

            if($clientValidator->getErrors())
                $clientErrors = $clientValidator->getErrors()->toArray();

            $errors =  $clientErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function saveImage()
    {

        $data = $this->data;

        $filename = time(). '.' .$data['image_profile']->getClientOriginalExtension();



        if($data['image_profile']->move('images_profile_clients', $filename))
        {
            $response = [
                'success' => true,
                'error' => '',
                'filename' => $filename,
                'path' => asset('/images_profile_clients/')
            ];
        }
        else
        {
            $response = [
                'success' => false,
                'error' => '',
            ];
        }

        return $response;

    }

    public function prepareData($data)
    {
        
        if(isset($data['image_profile']))
        {
            if(!is_object($data['image_profile']))
            {
                
            }else
            {
                $filename = \Str::slug($data['name']). '_' . time(). '.' .$data['image_profile']->getClientOriginalExtension();

                if($data['image_profile']->move('images_profile_clients', $filename))
                {
                    $data['image_profile'] = $filename;
                }

            }
        }else
        {
            if(isset($this->client->id))
            {
                $data['image_profile'] = $this->client->image_profile;
            }
        }

        return $data;
    }

} 