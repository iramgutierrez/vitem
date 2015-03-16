<?php namespace Vitem\Managers;

use Vitem\Repositories\PermissionRepo;
use Vitem\Validators\DeliveryValidator;
use Vitem\Managers\DestinationManager;


class DeliveryManager extends BaseManager {

    protected $delivery;

    public function setSaleId($id)
    {
        $data = $this->data;

        $data['sale_id'] = $id;

        $this->data = $data;

    }

    public function save()
    {
        $data = $this->data;

        $canCreateDestination = PermissionRepo::checkAuth('Destination' , 'Create');

        if(isset($data['new_destination']) && $canCreateDestination)
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

            $store_id = $delivery->sale->store_id;

            \Setting::checkSettingAndAddResidue('add_residue_new_delivery', $deliveryData['total'] , $store_id );

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

        $canCreateDestination = PermissionRepo::checkAuth('Destination' , 'Create');

        if(isset($data['new_destination']) && $canCreateDestination)
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

        $totalOld = $this->delivery->total;

        $store_id = $this->delivery->sale->store_id;

        $store_old = (!empty($deliveryData['store_id_old'])) ? $deliveryData['store_id_old'] : $store_id;

        $DeliveryValidator = new DeliveryValidator($this->delivery);

        $deliveryData = $this->prepareData($deliveryData);

        $deliveryValid  =  $DeliveryValidator->isValid($deliveryData);

        if( $deliveryValid )
        {

            $delivery = $this->delivery;
            
            $delivery->update($deliveryData);

            \Setting::checkSettingAndAddResidue('add_residue_new_delivery', $totalOld*(-1) , $store_old );

            \Setting::checkSettingAndAddResidue('add_residue_new_delivery', $deliveryData['total'] , $store_id );

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

        $deliveryData = $this->data;

        $this->delivery = \Delivery::find($deliveryData['id']);

        $delivery = $this->delivery;

        $store_id = $delivery->sale->store_id;

        \Setting::checkSettingAndAddResidue('add_residue_new_delivery', ( ($delivery->total)*(-1)  ) , $store_id );

        return $delivery->delete();

    }

    public function prepareData($deliveryData)
    {

        $deliveryData['user_id'] = \Auth::user()->id;

        $subtotal = 0;

        if(isset($deliveryData['destination_id']))
        {
            $destination = \Destination::find($deliveryData['destination_id']);

            if($destination)
            {
                $subtotal = $destination->cost;
            }
        }

        $commission_pay = 0;

        if(isset($deliveryData['pay_type_id']))
        {
            $payType = \PayType::find($deliveryData['pay_type_id']);

            if($payType)
            {
                $commission_pay = ($subtotal / 100) * $payType->percent_commission;
            }
        }

        $deliveryData['subtotal'] = number_format($subtotal, 2, '.', '');

        $deliveryData['commission_pay'] = number_format($commission_pay, 2, '.', '');

        $deliveryData['total'] = number_format(($subtotal - $commission_pay), 2, '.', '');

        return $deliveryData;
    }

} 

