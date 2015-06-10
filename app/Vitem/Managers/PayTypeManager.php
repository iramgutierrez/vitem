<?php namespace Vitem\Managers;

use Vitem\Validators\PayTypeValidator;


class PayTypeManager extends BaseManager {

    protected $pay_type;

    
    public function save()
    {
        $PayTypeValidator = new PayTypeValidator(new \PayType);

        $payTypeData = $this->data; 

        $payTypeData = $this->prepareData($payTypeData);

        $payTypeValid  =  $PayTypeValidator->isValid($payTypeData);

        if( $payTypeValid )
        {

            if(!empty($payTypeData['id']))
            {
                $payType = \PayType::find($payTypeData['id']);

                if($payType)
                {
                    unset($payTypeData['id']);

                    $payType->update($payTypeData);
                }

            }
            else
            {
                $payType = new \payType( $payTypeData ); 
            
                $payType->save(); 

            }
            
            

            $response = [
                'success' => true,
                'return_id' => $payType->id,
                'pay_type' => $payType
            ];            

        }
        else
        {
            
            $payTypeErrors = [];

            if($PayTypeValidator->getErrors())
                $payTypeErrors = $PayTypeValidator->getErrors()->toArray();            

            $errors =  $payTypeErrors;

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

    public function prepareData($payTypeData)
    {
        
        $payTypeData['user_id'] = \Auth::user()->id;

        return $payTypeData;
    }

} 

