<?php namespace Vitem\Managers;

use Vitem\Validators\DestinationValidator;


class DestinationManager extends BaseManager {

    protected $commission;

    
    public function save()
    {
        $DestinationValidator = new DestinationValidator(new \Destination);

        $destinationData = $this->data; 

        $destinationData = $this->prepareData($destinationData);

        $destinationValid  =  $DestinationValidator->isValid($destinationData);

        if( $destinationValid )
        {
            
            $destination = new \Destination( $destinationData ); 
            
            $destination->save(); 

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

    public function prepareData($commissionData)
    {
        
        $commissionData['user_id'] = \Auth::user()->id;

        return $commissionData;
    }

} 

