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

        $discountData = $this->data;

        $this->discount = \Discount::find($discountData['id']);

        $DiscountValidator = new DiscountValidator($this->discount);

        $discountData = $this->prepareData($discountData);

        $discountValid  =  $DiscountValidator->isValid($discountData);

        if( $discountValid )
        {

            $discount = $this->discount;

            $discount->update($discountData);

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

    public function delete()
    {

        
    }

    public function prepareData($discountData)
    {

        $discountData['user_id'] = \Auth::user()->id;

        $discountData['DiscountStore'] = (!empty($discountData['DiscountStore'])) ? explode(',' , $discountData['DiscountStore']) :[];

        $discountData['DiscountPayType'] = (!empty($discountData['DiscountPayType'])) ? explode(',' , $discountData['DiscountPayType']) :[];
       
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

