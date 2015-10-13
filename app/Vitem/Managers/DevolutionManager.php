<?php namespace Vitem\Managers;

use Vitem\Validators\DevolutionValidator;
use Vitem\Managers\ProductManager;


class DevolutionManager extends BaseManager {

    protected $devolution;


    public function save()
    {
        $DevolutionValidator = new DevolutionValidator(new \Devolution);

        $devolutionData = $this->data;

        $devolutionData = $this->prepareData($devolutionData);

        $devolutionValid  =  $DevolutionValidator->isValid($devolutionData);

        if( $devolutionValid )
        {

            $devolution = new \Devolution( $devolutionData );

            $devolution->save();

            if($devolutionData['status_pay'] == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'entity' => 'Devolution',
                    'type' => 'create',
                    'entity_id' => $devolution->id,
                    'amount_in' => $devolution->total,
                    'amount_out' => 0,
                    'date' => $devolution->devolution_date
                ]);

            }

            $devolution->products()->sync($devolutionData['ProductDevolution']);

            if(count( $devolutionData['ProductDevolution'] ))
            {

                foreach( $devolutionData['ProductDevolution'] as $kp => $p)
                {
                    if($p['status'] == 2)
                    {

                        $product = [

                            'id' => $kp

                        ];

                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock( ($p['quantity'] * (-1)) );

                    }

                }

            }

            $response = [
                'success' => true,
                'return_id' => $devolution->id
            ];

        }
        else
        {

            $devolutionErrors = [];

            if($DevolutionValidator->getErrors())
                $devolutionErrors = $DevolutionValidator->getErrors()->toArray();

            $errors =  $devolutionErrors;

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $devolutionData = $this->data;

        $this->devolution = \Devolution::with(['products' , 'supplier' , 'user'])
                     ->find($devolutionData['id']);

        $DevolutionValidator = new DevolutionValidator($this->devolution);

        $devolutionData = $this->prepareData($devolutionData);

        $devolutionValid  =  $DevolutionValidator->isValid($devolutionData);

        if( $devolutionValid)
        {

            $devolution = $this->devolution;

            $devolutionOld = $this->devolution;

            $devolutionOldStatusPay = $devolutionOld->status_pay;

            $devolutionOldTotal = $devolutionOld->total;

            $devolutionOldDate = $devolutionOld->devolution_date;

            $devolutionProductsOld = [];

            foreach($this->devolution->products as $k => $p)
            {

                $devolutionProductsOld[$p->pivot->product_id] = $p;
            }

            $devolution->update($devolutionData);

            if($devolutionData['status_pay'] == 'pagado' || $devolutionOldStatusPay == 'pagado')
            {

                if($devolutionData['status_pay'] == 'pagado' && $devolutionOldStatusPay == 'pagado')
                {
                    if($devolutionOldDate == $devolutionData['devolution_date'])
                    {
                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Devolution',
                            'type' => 'update',
                            'entity_id' => $devolution->id,
                            'amount_in' => $devolution->total,
                            'amount_out' => $devolutionOldTotal,
                            'date' => $devolutionData['devolution_date']
                        ]);
                    }
                    else
                    {
                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Devolution',
                            'type' => 'update',
                            'entity_id' => $devolution->id,
                            'amount_in' => 0,
                            'amount_out' => $devolutionOldTotal,
                            'date' => $devolutionOldDate
                        ]);

                        \Movement::create([
                            'user_id' => \Auth::user()->id,
                            'entity' => 'Devolution',
                            'type' => 'update',
                            'entity_id' => $devolution->id,
                            'amount_in' => $devolution->total,
                            'amount_out' => 0,
                            'date' => $devolutionData['devolution_date']
                        ]);

                    }


                }
                else if($devolutionData['status_pay'] == 'pagado')
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'entity' => 'Devolution',
                        'type' => 'update',
                        'entity_id' => $devolution->id,
                        'amount_in' => $devolution->total,
                        'amount_out' => 0,
                        'date' => $devolutionData['devolution_date']
                    ]);
                }
                else if($devolutionOldStatusPay == 'pagado')
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'entity' => 'Devolution',
                        'type' => 'update',
                        'entity_id' => $devolution->id,
                        'amount_in' => 0,
                        'amount_out' => $devolutionOldTotal,
                        'date' => $devolutionOldDate
                    ]);
                }

            }

            $devolution->products()->sync($devolutionData['ProductDevolution']);

            if(count($devolutionData['ProductDevolution']))
            {
                foreach($devolutionData['ProductDevolution'] as $kp => $p)
                {
                    if( !empty($devolutionProductsOld[$kp]) && !empty($devolutionData['ProductDevolution'][$kp]))
                    {

                        if($devolutionProductsOld[$kp]->pivot->status != $devolutionData['ProductDevolution'][$kp]['status'])
                        {


                            $status = 1;

                            if($devolutionData['ProductDevolution'][$kp]['status'] == 1)
                            {
                                $status = -1;
                            }

                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $devolutionData['ProductDevolution'][$kp]['quantity'] * ($status) * (-1) );


                        } else if( $devolutionProductsOld[$kp]->pivot->status == 2 && $devolutionData['ProductDevolution'][$kp]['status'] == 2 && $devolutionProductsOld[$kp]->pivot->quantity != $devolutionData['ProductDevolution'][$kp]['quantity'])
                        {

                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $devolutionProductsOld[$kp]->pivot->quantity  );

                            $addStockProduct->addStock( $devolutionData['ProductDevolution'][$kp]['quantity'] * (-1));

                        }

                        unset($devolutionProductsOld[$kp]);

                    }
                    else
                    {
                        if($p['status'] == 2)
                        {
                            $product = [

                                'id' => $kp

                            ];

                            $addStockProduct = new ProductManager( $product );

                            $addStockProduct->addStock( $p['quantity']* (-1) );

                        }
                    }


                }

            }

            if(count( $devolutionProductsOld))
            {

                foreach( $devolutionProductsOld as $kp => $p)
                {
                    if($p->pivot->status == 2)
                    {
                        $product = [

                            'id' => $kp

                        ];

                        $addStockProduct = new ProductManager( $product );

                        $addStockProduct->addStock( ($p->pivot->quantity) );

                    }

                }

            }

            $response = [
                'success' => true,
                'return_id' => $devolution->id
            ];

        }
        else
        {

            $devolutionErrors = [];

            if($DevolutionValidator->getErrors())
                $DevolutionErrors = $DevolutionValidator->getErrors()->toArray();

            $errors =  $devolutionErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $devolutionData = $this->data;

        $this->devolution = \Devolution::with('products')
                           ->with('user')
                           ->with('supplier')
                           ->find($devolutionData['id']);

        $devolution = $this->devolution;

        if(count( $devolution->products))
        {

            foreach( $devolution->products as $kp => $p)
            {
                if($p->pivot->status == 2)
                {
                    $product = [

                        'id' => $p->id

                    ];

                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p->pivot->quantity) );

                }

            }

        }

        $devolution->products()->detach();


        if($devolution->status_pay == 'pagado')
        {
            \Movement::create([
                'user_id' => \Auth::user()->id,
                'entity' => 'Devolution',
                'type' => 'delete',
                'entity_id' => $devolution->id,
                'amount_in' => 0,
                'amount_out' => $devolution->total,
                'date' => $devolution->devolution_date
            ]);

        }

        return $devolution->delete();

    }

    public function prepareData($devolutionData)
    {

        $devolutionData['user_id'] = \Auth::user()->id;

        $total = 0;

        if(!empty($devolutionData['ProductDevolution']))
        {
            foreach($devolutionData['ProductDevolution'] as $k => $p)
            {
                $product = \Product::find($k);

                $cost = (float) $product->cost * $p['quantity'];

                $total += $cost;
            }

        }

        $devolutionData['total'] = number_format( $total, 2, '.', '');

        return $devolutionData;
    }

}

