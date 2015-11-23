<?php namespace Vitem\Managers;

use Vitem\Validators\DiscountValidator;


class DiscountManager extends BaseManager {

    protected $discount;


    public function save()
    {
        $DiscountValidator = new DiscountValidator(new \Discount);

        $discountData = $this->data;

        $discountData = $this->prepareData($discountData);

        $discountValid  =  $DiscountValidator->isValid($discountData);

        if( $discountValid )
        {

            $discount = new \Discount( $discountData );

            $discount->save();

            $discount->stores()->sync($discountData['DiscountStore']);

            $discount->pay_types()->sync($discountData['DiscountPayType']);

            $response = [
                'success' => true,
                'return_id' => $discount->id
            ];

        }
        else
        {

            $discountErrors = [];

            if($DiscountValidator->getErrors())
                $discountErrors = $DiscountValidator->getErrors()->toArray();

            $errors =  $discountErrors;

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $destinationData = $this->data; 
        

        $this->destination = \Destination::find($destinationData['id']);

        $DestinationValidator = new DestinationValidator($this->destination);

        $destinationData = $this->prepareData($destinationData);

        $destinationValid  =  $DestinationValidator->isValid($destinationData); 


        if( $destinationValid )
        {

            $destination = $this->destination;
            
            $destination->update($destinationData); 

            $response = [
                'success' => true,
                'return_id' => $destination->id
            ];            

        }
        else
        {
            
            $destinationErrors = [];

            if($DestinationValidator->getErrors())
                $destinationErrors = $DestinationValidator->getErrors()->toArray();            

            $errors =  $destinationErrors;

            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        
    }

    public function prepareData($discountData)
    {

        $discountData['user_id'] = \Auth::user()->id;

        $discountData['DiscountStore'] = (!empty($discountData['stores'])) ? $discountData['stores'] :[];

        $discountData['DiscountPayType'] = (!empty($discountData['pay_types'])) ? $discountData['pay_types'] :[];

        if(isset($discountData['stores']))
        {
            unset($discountData['stores']);
        }

        if(isset($discountData['pay_types']))
        {
            unset($discountData['pay_types']);
        }


        if( $discountData['type'] == 1 && isset($discountData['item_type']))
        {
            $discountData['item_type'] = ucfirst($discountData['item_type']);
        }

        return $discountData;
    }

} 

