<?php namespace Vitem\Managers;

use Vitem\Validators\PackValidator;
use Vitem\Managers\ProductManager;


class PackManager extends BaseManager {

    protected $pack;

    
    public function save()
    {
        $PackValidator = new PackValidator(new \Pack);

        $packData = $this->data;  

        //$packData = $this->preparePackProduct($packData);

        $packValid  =  $PackValidator->isValid($packData);

        if( $packValid )
        {


            $packData = $this->prepareData( $packData ); 

            $pack = new \Pack( $packData );  
            
            $pack->save();

            $pack->products()->sync($packData['PackProduct']);


            $response = [
                'success' => true,
                'return_id' => $pack->id
            ];            

        }
        else
        {
            
            $packErrors = [];

            if($PackValidator->getErrors())
                $packErrors = $PackValidator->getErrors()->toArray();            

            $errors =  $packErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $packData = $this->data; 

        $this->pack = \Pack::find($packData['id']);

        $PackValidator = new PackValidator($this->pack);

        //$packData = $this->preparePackProduct($packData);

        $packValid  =  $PackValidator->isValid($packData);

        if( $packValid )
        {     

            $packData = $this->prepareData( $packData ); 

            $pack = $this->pack;
            
            $pack->update($packData);

            $pack->products()->sync($packData['PackProduct']);

            $response = [
                'success' => true
            ];            

        }
        else
        {
            
            $packErrors = [];

            if($PackValidator->getErrors())
                $packErrors = $PackValidator->getErrors()->toArray();

            $errors =  $packErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    function preparePackProduct($packData)
    {

        $PackProduct = $packData['PackProduct'];

        $packData['PackProducts'] = [];

        foreach($PackProduct as $k => $p)
        {
            if($p['product_id'])
            {
                
                $quantity = (isset($packData['PackProducts'][$p['product_id']]['quantity'])) ? $packData['PackProducts'][$p['product_id']]['quantity'] + $p['quantity'] : $p['quantity'];

                $packData['PackProducts'][$p['product_id']] = [
                    'quantity' => $quantity
                ];
            }
            else
            {
                unset($PackProduct[$k]);
            }

        }

        $packData['PackProduct'] = array_values($PackProduct);


        return $packData;

    }

    public function prepareData($data)
    {
        
        $data['user_id'] = \Auth::user()->id;


        if(isset($data['image']))
        {
            if(!is_object($data['image']))
            {     
                
            }else
            {
                $filename = \Str::slug($data['key']). '_' . time(). '.' .$data['image']->getClientOriginalExtension();

                if($data['image']->move('images_packs', $filename))
                {
                    $data['image'] = $filename;
                }

            }
        }else
        {
            if(isset($this->pack->id))
            {
                $data['image'] = $this->pack->image;
            }
        }

        return $data;
    }

    public function addStock($quantity)
    { 

        $packData = $this->data;

        $this->pack = \Pack::find($packData['id']);

        if($this->pack)
        {

            $pack = $this->pack;

            foreach($pack->products as $kp => $p)
            { 

                $product = [

                    'id' => $p->id

                ];
                        
                $addStockProduct = new ProductManager( $product );

                $addStockProduct->addStock($p->pivot->quantity * $quantity);

            }        

        }

        return true;

    }

} 

