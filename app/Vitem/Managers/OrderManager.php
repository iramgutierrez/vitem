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
            //dd($orderData);
            $order = new \Order( $orderData );

            $order->save();

            if($orderData['status_pay'] == 'pagado')
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'entity' => 'Order',
                    'type' => 'create',
                    'entity_id' => $order->id,
                    'amount_in' => 0,
                    'amount_out' => $order->total,
                    'date' => $order->order_date
                ]);
            }

            $order->products()->sync($orderData['ProductOrder']);

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

                        $addStockProduct->addStock( ($p['quantity']) );

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

            $orderOldStatusPay = $orderOld->status_pay;

            $orderOldTotal = $orderOld->total;

            $orderOldDate = $orderOld->order_date;

            $orderProductsOld = [];

            foreach($this->order->products as $k => $p)
            {

                $orderProductsOld[$p->pivot->product_id] = $p;
            }

            $order->update($orderData);

            if($orderData['status_pay'] == 'pagado' || $orderOldStatusPay == 'pagado')
            {

                if($orderData['status_pay'] == 'pagado' && $orderOldStatusPay == 'pagado')
                {
                    if($orderOldDate == $orderData['order_date'])
                    {
                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Order',
                            'type' => 'update',
                            'entity_id' => $order->id,
                            'amount_in' => $orderOldTotal,
                            'amount_out' => $order->total,
                            'date' => $orderData['order_date']
                        ]);
                    }
                    else
                    {
                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Order',
                            'type' => 'update',
                            'entity_id' => $order->id,
                            'amount_in' => $orderOldTotal,
                            'amount_out' => 0,
                            'date' => $orderOldDate
                        ]);

                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Order',
                            'type' => 'update',
                            'entity_id' => $order->id,
                            'amount_in' => 0,
                            'amount_out' => $order->total,
                            'date' => $orderData['order_date']
                        ]);


                    }

                }
                else if($orderData['status_pay'] == 'pagado')
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'entity' => 'Order',
                        'type' => 'update',
                        'entity_id' => $order->id,
                        'amount_in' => 0,
                        'amount_out' => $order->total,
                        'date' => $orderData['order_date']
                    ]);
                }
                else if($orderOldStatusPay == 'pagado')
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'entity' => 'Order',
                        'type' => 'update',
                        'entity_id' => $order->id,
                        'amount_in' => $orderOldTotal,
                        'amount_out' => 0,
                        'date' => $orderOldDate
                    ]);
                }

            }

            $order->products()->sync($orderData['ProductOrder']);

            if(count($orderData['ProductOrder']))
            {
                foreach($orderData['ProductOrder'] as $kp => $p)
                {
                    if( !empty($orderProductsOld[$kp]) && !empty($orderData['ProductOrder'][$kp]))
                    {

                        if($orderProductsOld[$kp]->pivot->status != $orderData['ProductOrder'][$kp]['status'])
                        {


                            $status = 1;

                            if($orderData['ProductOrder'][$kp]['status'] == 1)
                            {
                                $status = -1;
                            }

                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $orderData['ProductOrder'][$kp]['quantity'] * ($status) );


                        } else if( $orderProductsOld[$kp]->pivot->status == 2 && $orderData['ProductOrder'][$kp]['status'] == 2 && $orderProductsOld[$kp]->pivot->quantity != $orderData['ProductOrder'][$kp]['quantity'])
                        {

                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $orderProductsOld[$kp]->pivot->quantity  * (-1) );

                            $addStockProduct->addStock( $orderData['ProductOrder'][$kp]['quantity'] );

                        }

                        unset($orderProductsOld[$kp]);

                    }
                    else
                    {
                        if($p['status'] == 2)
                        {
                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $p['quantity'] );

                        }
                    }


                }

            }

            if(count( $orderProductsOld))
            {

                foreach( $orderProductsOld as $kp => $p)
                {
                    if($p->pivot->status == 2)
                    {
                        $product = [

                            'id' => $kp

                        ];

                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock( ($p->pivot->quantity) * (-1) );

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

        if(count( $order->products))
        {

            foreach( $order->products as $kp => $p)
            {
                if($p->pivot->status == 2)
                {
                    $product = [

                        'id' => $p->id

                    ];

                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p->pivot->quantity) * (-1) );

                }

            }

        }

        $order->products()->detach();

        if($order->status_pay == 'pagado')
        {
            \Movement::create([
                'user_id' => \Auth::user()->id,
                'entity' => 'Order',
                'type' => 'delete',
                'entity_id' => $order->id,
                'amount_in' => $order->total,
                'amount_out' => 0,
                'date' => $order->order_date
            ]);

        }

        return $order->delete();

    }

    public function prepareData($orderData)
    {

        $orderData['user_id'] = \Auth::user()->id;

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

