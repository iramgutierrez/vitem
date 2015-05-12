<?php namespace Vitem\Managers;

use Vitem\Validators\ClientTypeValidator;


class ClientTypeManager extends BaseManager {

    protected $client_type;

    
    public function save()
    {
        $ClientTypeValidator = new ClientTypeValidator(new \ClientType);

        $clientTypeData = $this->data; 

        $clientTypeData = $this->prepareData($clientTypeData);

        $clientTypeValid  =  $ClientTypeValidator->isValid($clientTypeData);

        if( $clientTypeValid )
        {

            if(!empty($clientTypeData['id']))
            {
                $clientType = \ClientType::find($clientTypeData['id']);

                if($clientType)
                {
                    unset($clientTypeData['id']);

                    $clientType->update($clientTypeData);
                }

            }
            else
            {
                $clientType = new \clientType( $clientTypeData ); 
            
                $clientType->save(); 

            }
            
            

            $response = [
                'success' => true,
                'return_id' => $clientType->id,
                'client_type' => $clientType
            ];            

        }
        else
        {
            
            $clientTypeErrors = [];

            if($ClientTypeValidator->getErrors())
                $clientTypeErrors = $ClientTypeValidator->getErrors()->toArray();            

            $errors =  $clientTypeErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {
    }

    public function delete()
    {

        

    }

    public function prepareData($clientTypeData)
    {
        
        $clientTypeData['user_id'] = \Auth::user()->id;

        $clientTypeData['slug'] = \Str::slug($clientTypeData['name']);

        return $clientTypeData;
    }

} 

