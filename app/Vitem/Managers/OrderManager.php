<?php namespace Vitem\Managers;

use Vitem\Validators\OrderValidator;
use Vitem\Managers\ProductManager;


class OrderManager extends BaseManager {

    protected $order;

    
    public function save()
    {
        $OrderValidator = new OrderValidator(new \Order);

        $orderData = $this->data;

        $orderData = $this->prepareData($orderData);

        $orderValid  =  $OrderValidator->isValid($orderData);

        if( $orderValid )
        {
                 
            $order = new \Order( $orderData );
            
            $order->save();

            \Setting::checkSettingAndAddResidue('add_residue_new_order', $orderData['total']*(-1) );

            $order->products()->sync($orderData['ProductOrder']);

            if(count( $orderData['ProductOrder'] ))
            {

                foreach( $orderData['ProductOrder'] as $kp => $p)
                {
                    $product = [

                        'id' => $kp

                    ];
                        
                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p['quantity']) );

                }

            }

            $response = [
                'success' => true,
                'return_id' => $order->id
            ];            

        }
        else
        {
            
            $orderErrors = [];

            if($OrderValidator->getErrors())
                $orderErrors = $OrderValidator->getErrors()->toArray();

            $errors =  $orderErrors;

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $orderData = $this->data; 

        $this->order = \Order::with(['products' , 'supplier' , 'user'])
                     ->find($orderData['id']);

        $OrderValidator = new OrderValidator($this->order);

        $orderData = $this->prepareData($orderData);

        $orderValid  =  $OrderValidator->isValid($orderData);

        if( $orderValid)
        {

            $order = $this->order;

            $orderOld = $this->order; 

            \Setting::checkSettingAndAddResidue('add_residue_new_order', ( ($orderOld->total)*(-1)  ) );

            \Setting::checkSettingAndAddResidue('add_residue_new_order',  $orderData['total']  );         

            $order->update($orderData);

            $order->products()->sync($orderData['ProductOrder']);

            if(count($order->products))
            {

                foreach($order->products as $kp => $p)
                {
                    
                    if($p->pivot->status == 2)
                    {
                        $product = [

                            'id' => $p->id

                        ];

                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock( $p->pivot->quantity * (-1) );

                    }
                    

                }

            }

            if(count( $orderData['ProductOrder'] ))
            { 

                foreach( $orderData['ProductOrder'] as $kp => $p)
                { 
                    if($p['status'] == 2)
                    {
                        $product = [

                            'id' => $kp

                        ];
                            
                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock( ($p['quantity'])  );

                    }

                }

            }

            $response = [
                'success' => true,
                'return_id' => $order->id
            ];            

        }
        else
        {
            
            $orderErrors = [];

            if($OrderValidator->getErrors())
                $orderErrors = $OrderValidator->getErrors()->toArray();            

            $errors =  $orderErrors;            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $orderData = $this->data;

        $this->order = \Order::with('products')
                           ->with('user')
                           ->with('supplier')
                           ->find($orderData['id']);
        
        $order = $this->order;

        $order->products()->detach();

        return $order->delete();

    }

    public function prepareData($orderData)
    {
        
        $orderData['user_id'] = \Auth::user()->id;

        $orderData['store_id'] = 1;

        $total = 0;

        if(!empty($orderData['ProductOrder']))
        {
            foreach($orderData['ProductOrder'] as $k => $p)
            {
                $product = \Product::find($k);

                $cost = (float) $product->cost * $p['quantity'];

                $total += $cost;
            }

        }

        $orderData['total'] = number_format( $total, 2, '.', '');

        return $orderData;
    }

} 

