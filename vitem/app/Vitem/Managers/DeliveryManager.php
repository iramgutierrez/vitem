<?php namespace Vitem\Managers;

use Vitem\Validators\DeliveryValidator;

use Vitem\Managers\DestinationManager;


class DeliveryManager extends BaseManager {

    protected $delivery;

    public function save()
    {
        $data = $this->data;

        if(isset($data['new_destination']))
        {
            return $this->saveWithNewDestination();
        }
        else
        {
            return $this->saveWithExistsDestination();
        }        

    }

    public function saveWithNewDestination()
    {

        $data = $this->data;

        $createDestination = new DestinationManager( $data['destination'] );

        $responseDestination = $createDestination->save();

        if(isset($responseDestination['return_id']))
        {
            $data['destination_id'] = $responseDestination['return_id'];
        }

        $this->data = $data;

        $responseDelivery = $this->saveWithExistsDestination();        

        if($responseDestination['success'] && $responseDelivery['success'])
        {
            $response = $responseDelivery;
        }
        else
        {
            if(isset($responseDestination['errors']))
            {
                foreach($responseDestination['errors'] as $k => $e)
                {

                    $responseDestination['errors']['destination.'.$k] = $e;

                    unset($responseDestination['errors'][$k]);

                }  
            }            

            $errors = ( (isset( $responseDestination['errors'] ) ) ? $responseDestination['errors'] : [] )

                    + ( (isset( $responseDelivery['errors'] ) ) ? $responseDelivery['errors'] : [] );

            $response = [
                'success' => false,
                'errors' => $errors,
                'newDestination' => true,
                'destinationSelectedId' => 0
            ];
        }

        return $response;

    }

    
    public function saveWithExistsDestination()
    {
        $DeliveryValidator = new DeliveryValidator(new \Delivery);

        $deliveryData = $this->data; 

        $deliveryData = $this->prepareData($deliveryData);

        $deliveryValid  =  $DeliveryValidator->isValid($deliveryData);

        if( $deliveryValid )
        {
            
            $delivery = new \Delivery( $deliveryData ); 
            
            $delivery->save(); 

            $response = [
                'success' => true,
                'return_id' => $delivery->id
            ];            

        }
        else
        {
            
            $deliveryErrors = [];

            if($DeliveryValidator->getErrors())
                $deliveryErrors = $DeliveryValidator->getErrors()->toArray();            

            $errors =  $deliveryErrors;

            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $deliveryData = $this->data;  

        if(isset($deliveryData['new_destination']))
        {
            return $this->updateWithNewDestination();
        }
        else
        {
            return $this->updateWithExistsDestination();
        }       

        

    }

    public function updateWithNewDestination()
    {

        $data = $this->data;

        $createDestination = new DestinationManager( $data['destination'] );

        $responseDestination = $createDestination->save();

        if(isset($responseDestination['return_id']))
        {
            $data['destination_id'] = $responseDestination['return_id'];
        }

        $this->data = $data;

        $responseDelivery = $this->updateWithExistsDestination();        

        if($responseDestination['success'] && $responseDelivery['success'])
        {
            $response = $responseDelivery;
        }
        else
        {
            if(isset($responseDestination['errors']))
            {
                foreach($responseDestination['errors'] as $k => $e)
                {

                    $responseDestination['errors']['destination.'.$k] = $e;

                    unset($responseDestination['errors'][$k]);

                }  
            }            

            $errors = ( (isset( $responseDestination['errors'] ) ) ? $responseDestination['errors'] : [] )

                    + ( (isset( $responseDelivery['errors'] ) ) ? $responseDelivery['errors'] : [] );

            $response = [
                'success' => false,
                'errors' => $errors,
                'newDestination' => true,
                'destinationSelectedId' => 0
            ];
        }

        return $response;

    }

    public function updateWithExistsDestination()
    {
        $deliveryData = $this->data;  

        $this->delivery = \Delivery::find($deliveryData['id']);

        $DeliveryValidator = new DeliveryValidator($this->delivery);

        $deliveryData = $this->prepareData($deliveryData);

        $deliveryValid  =  $DeliveryValidator->isValid($deliveryData); 

        if( $deliveryValid )
        {

            $delivery = $this->delivery;
            
            $delivery->update($deliveryData);             

            $response = [
                'success' => true,
                'return_id' => $delivery->id
            ];            

        }
        else
        {
            
            $deliveryErrors = [];

            if($DeliveryValidator->getErrors())
                $deliveryErrors = $DeliveryValidator->getErrors()->toArray();            

            $errors =  $deliveryErrors;

            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $saleData = $this->data; 

        $this->sale = \Sale::with('products')
                           ->with('packs')
                           ->with('client')
                           ->with('employee')
                           ->find($saleData['id']);

                           echo "<pre>";
        if($this->sale)
        { 

            if($saleData['add_stock'])
            {
                if(count($this->sale->products))
                {

                    foreach($this->sale->products as $kp => $p)
                    {
                        $product = [

                            'id' => $p->id

                        ];
                        
                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock($p->pivot->quantity);

                    }

                }

                if(count($this->sale->packs))
                {

                    foreach($this->sale->packs as $kp => $p)
                    {
                        $pack = [

                            'id' => $p->id

                        ];
                        
                        $addStockPack = new PackManager( $pack );

                        $addStockPack->addStock($p->pivot->quantity);

                    }

                }
            }

        }

        $sale = $this->sale;

        $sale->products()->detach();

        $sale->packs()->detach();

        return $sale->delete();

    }

    public function prepareData($commissionData)
    {
        
        $commissionData['user_id'] = \Auth::user()->id;

        return $commissionData;
    }

} 

