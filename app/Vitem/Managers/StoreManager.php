<?php namespace Vitem\Managers;

use Vitem\Validators\StoreValidator;


class StoreManager extends BaseManager {

    protected $store;

    
    public function save()
    {
        $StoreValidator = new StoreValidator(new \Store);

        $storeData = $this->data;

        $storeData = $this->prepareData($storeData);

        $storeValid  =  $StoreValidator->isValid($storeData);

        if( $storeValid )
        {
                 
            $store = new \Store( $storeData );
            
            $store->save();

            $response = [
                'success' => true,
                'return_id' => $store->id
            ];            

        }
        else
        {
            
            $storeErrors = [];

            if($StoreValidator->getErrors())
                $storeErrors = $StoreValidator->getErrors()->toArray();

            $errors =  $storeErrors;

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $storeData = $this->data; 

        $this->store = \Store::with(['user'])
                     ->find($storeData['id']);

        $StoreValidator = new StoreValidator($this->store);

        $storeData = $this->prepareData($storeData);

        $storeValid  =  $StoreValidator->isValid($storeData);

        if( $storeValid)
        {

            $store = $this->store;

            $store->update($storeData);

            $response = [
                'success' => true,
                'return_id' => $store->id
            ];            

        }
        else
        {
            
            $storeErrors = [];

            if($StoreValidator->getErrors())
                $storeErrors = $StoreValidator->getErrors()->toArray();            

            $errors =  $storeErrors;            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $storeData = $this->data;

        $this->store = \Store::with('user')
                           ->find($storeData['id']);
        
        $store = $this->store;

        return $store->delete();

    }

    public function prepareData($storeData)
    {
        
        $storeData['user_id'] = \Auth::user()->id;        

        return $storeData;
    }

} 

