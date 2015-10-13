<?php namespace Vitem\Managers;

use Vitem\Repositories\PermissionRepo;
use Vitem\Validators\SaleValidator;
use Vitem\Managers\ProductManager;
use Vitem\Managers\PackManager;
use Vitem\Managers\SalePaymentManager;
use Vitem\Managers\DeliveryManager;
use Vitem\Validators\DeliveryValidator;
use Vitem\Validators\DestinationValidator;


class SaleManager extends BaseManager {

    protected $sale;


    public function save()
    {
        $SaleValidator = new SaleValidator(new \Sale);

        $saleData = $this->data;

        $saleData = $this->preparePackProductSale($saleData);

        $saleData = $this->prepareData($saleData);

        $saleValid  =  $SaleValidator->isValid($saleData);

        $deliveryValid = true;

        $destinationValid = true;

        $canCreateDelivery = PermissionRepo::checkAuth('Delivery' , 'Create');

        if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery)
        {

            $deliveryData = $saleData['delivery'];

            $deliveryData['user_id'] = \Auth::user()->id;

            $deliveryData['pay_type_id'] = $saleData['pay_type_id'];

            $createDelivery = new DeliveryManager( $deliveryData );

            $deliveryData = $createDelivery->prepareData($deliveryData);

            $newDestination = (isset($deliveryData['new_destination']) && $deliveryData['new_destination']) ? true : false;

            $DeliveryValidator = new DeliveryValidator(new \Delivery , true , $newDestination);

            $deliveryValid  =  $DeliveryValidator->isValid($deliveryData);

            if($newDestination)
            {

                $DestinationValidator = new DestinationValidator(new \Destination);

                $destinationValid  =  $DestinationValidator->isValid($deliveryData['destination']);

            }

        }

        if( $saleValid && $deliveryValid && $destinationValid)
        {

            $sale = new \Sale( $saleData );

            $sale->save();

            foreach($saleData['ColorProductSale'] as $k => $c)
            {

              $ColorProduct = \ColorProduct::find($k);

              if($ColorProduct)
              {

                  $ColorProduct->quantity -= $c['quantity'];

                  $ColorProduct->save();

              }

            }

            if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery) {


                $createDelivery->setSaleId($sale->id);

                $createDelivery->save();

            }

            if($saleData['sale_type'] == 'contado')
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $sale->store_id,
                    'type' => 'create',
                    'entity' => 'Sale',
                    'entity_id' => $sale->id,
                    'amount_in' => $sale->subtotal,
                    'amount_out' => 0,
                    'date' => $sale->sale_date
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id']);

            }

            $sale->colors_products()->sync($saleData['ColorProductSale']);

            $sale->packs()->sync($saleData['PackSale']);

            $sale->products()->sync($saleData['ProductSale']);

            if($saleData['sale_type'] == 'apartado')
            {

                $salePaymentData = [

                    'subtotal' => $saleData['down_payment'],

                    'sale_id' => $sale->id,

                    'employee_id' => $sale->employee_id,

                    'pay_type_id' => $sale->pay_type_id
                ];

                $addSalePayment = new SalePaymentManager( $salePaymentData );

                $salePaymentResponse = $addSalePayment->save();

            }

            if(count( $saleData['ProductSale'] ))
            {

                foreach( $saleData['ProductSale'] as $kp => $p)
                {
                    $product = [

                        'id' => $kp

                    ];

                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p['quantity']) * (-1) /*, $saleData['store_id']*/ );

                }

            }

            if(count( $saleData['PackSale'] ))
            {

                foreach( $saleData['PackSale'] as $kp => $p)
                {

                    $pack = [

                        'id' => $kp

                    ];

                    $addStockPack = new PackManager( $pack );

                    $addStockPack->addStock( ($p['quantity']) * (-1) );

                }

            }


            $response = [
                'success' => true,
                'return_id' => $sale->id
            ];

        }
        else
        {

            $saleErrors = [];

            if($SaleValidator->getErrors())
                $saleErrors = $SaleValidator->getErrors()->toArray();

            $errors =  $saleErrors;

            if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery)
            {

                $deliveryErrors = [];

                $destinationErrors = [];

                if ($DeliveryValidator->getErrors()) {

                    $deliveryErrors = $DeliveryValidator->getErrors()->toArray();

                    foreach ($deliveryErrors as $k => $e) {

                        $deliveryErrors['delivery.' . $k] = $e;

                        unset($deliveryErrors[$k]);

                    }
                }

                if($newDestination)
                {
                    if ($DestinationValidator->getErrors()) {

                        $destinationErrors = $DestinationValidator->getErrors()->toArray();

                        foreach ($destinationErrors as $k => $e) {

                            $destinationErrors['delivery.destination.' . $k] = $e;

                            unset($destinationErrors[$k]);

                        }
                    }
                }

                $errors =  $saleErrors + $deliveryErrors + $destinationErrors;
            }

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $saleData = $this->data;

        $this->sale = \Sale::with('products')
                     ->with('packs')
                     ->with('client')
                     ->with(['employee' , 'employee.user' , 'sale_payments', 'colors_products'])
                     ->find($saleData['id']);

        $saleTypeOld = $this->sale->sale_type;

        $totalOld = $this->sale->subtotal;

        $storeOld = $this->sale->store_id;

        $saleDateOld = $this->sale->sale_date;

        $SaleValidator = new SaleValidator($this->sale);

        $saleData = $this->preparePackProductSale($saleData);

        $saleData = $this->prepareData($saleData);

        $saleValid  =  $SaleValidator->isValid($saleData);

        $deliveryData = $saleData['delivery'];

        $deliveryValid = true;

        $destinationValid = true;

        $canCreateDelivery = PermissionRepo::checkAuth('Delivery' , 'Create');

        if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery)
        {
            $deliveryData['user_id'] = \Auth::user()->id;

            $deliveryData['pay_type_id'] = $saleData['pay_type_id'];

            $deliveryData['sale_id'] = $saleData['id'];

            $deliveryData['store_id_old'] = $saleData['store_id'];

            $createDelivery = new DeliveryManager( $deliveryData );

            $deliveryData = $createDelivery->prepareData($deliveryData);

            $newDestination = (isset($deliveryData['new_destination']) && $deliveryData['new_destination']) ? true : false;

            $DeliveryValidator = new DeliveryValidator(new \Delivery , true , $newDestination);

            $deliveryValid  =  $DeliveryValidator->isValid($deliveryData);

            if($newDestination)
            {

                $DestinationValidator = new DestinationValidator(new \Destination);

                $destinationValid  =  $DestinationValidator->isValid($deliveryData['destination']);

            }

        }

        if( $saleValid && $deliveryValid && $destinationValid)
        {


            $sale = $this->sale;

            $saleOld = $this->sale;

            $sale->update($saleData);


            foreach($saleData['ColorProductSale'] as $k => $c)
            {

              $ColorProduct = \ColorProduct::find($k);

              $ColorProduct->quantity -= $c['quantity'];

              $ColorProduct->save();
            }

           foreach($saleOld->colors_products->toArray() as $k => $c)
           {

             $ColorProduct = \ColorProduct::find($c['id']);

             $ColorProduct->quantity += $c['pivot']['quantity'];

             $ColorProduct->save();
           }

           $sale->colors_products()->sync($saleData['ColorProductSale']);




            if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery )
            {
                if(isset($deliveryData['id']))
                {

                    $createDelivery->update();

                }else{

                    $createDelivery->save();

                }

            }

            if($saleData['delivery_type'] != 1 && isset($deliveryData['id']))
            {

                $deleteDelivery = new DeliveryManager( $deliveryData );

                $deleteDelivery->delete();

            }

            if($sale->sale_type == 'apartado')
            {

                $sale_payment = \SalePayment::where('sale_id' , $sale->id)->first();

                if($sale_payment)
                {
                    $salePaymentData = [

                        'subtotal' => $saleData['down_payment'],

                        'id' => $sale_payment->id,

                        'sale_id' => $sale->id,

                        'store_id_old' => $saleOld->store_id,

                        'employee_id' => $sale->employee_id,

                        'pay_type_id' => $sale->pay_type_id
                    ];

                    $addSalePayment = new SalePaymentManager( $salePaymentData );

                    $addSalePayment->update();

                }
                else
                {
                    $salePaymentData = [

                        'subtotal' => $saleData['down_payment'],

                        'sale_id' => $sale->id,

                        'employee_id' => $sale->employee_id,

                        'pay_type_id' => $sale->pay_type_id
                    ];

                    $addSalePayment = new SalePaymentManager( $salePaymentData );

                    $addSalePayment->save();

                }



            }

            if($saleTypeOld == 'contado' && $sale->sale_type == 'apartado')
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $sale->store_id,
                    'type' => 'update',
                    'entity' => 'Sale',
                    'entity_id' => $sale->id,
                    'amount_in' => 0,
                    'amount_out' => $totalOld,
                    'date' => $sale->sale_date
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1) , $saleOld->store_id );

            }elseif($saleTypeOld == 'contado' && $sale->sale_type == 'contado'){

                if($saleDateOld == $sale->sale_date && $storeOld == $sale->store_id)
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $sale->store_id,
                        'type' => 'update',
                        'entity' => 'Sale',
                        'entity_id' => $sale->id,
                        'amount_in' => $saleData['subtotal'],
                        'amount_out' => $totalOld,
                        'date' => $sale->sale_date
                    ]);
                }
                else
                {

                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $storeOld,
                        'type' => 'update',
                        'entity' => 'Sale',
                        'entity_id' => $sale->id,
                        'amount_in' => 0,
                        'amount_out' => $totalOld,
                        'date' => $saleDateOld
                    ]);

                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $sale->store_id,
                        'type' => 'update',
                        'entity' => 'Sale',
                        'entity_id' => $sale->id,
                        'amount_in' => $saleData['subtotal'],
                        'amount_out' => 0,
                        'date' => $sale->sale_date
                    ]);
                }


                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1) , $saleOld->store_id );

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id'] );

            }elseif($saleTypeOld == 'apartado' && $sale->sale_type == 'contado'){


                foreach($sale->sale_payments as $sale_payment)
                {
                    $salePaymentData = [

                        'id' => $sale_payment->id

                    ];

                    $deleteSalePayment = new SalePaymentManager( $salePaymentData );

                    $deleteSalePayment->delete();
                }

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $sale->store_id,
                    'type' => 'update',
                    'entity' => 'Sale',
                    'entity_id' => $sale->id,
                    'amount_in' => $saleData['subtotal'],
                    'amount_out' => 0,
                    'date' => $sale->sale_date
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id'] );

            }



            $sale->packs()->sync($saleData['PackSale']);

            $sale->products()->sync($saleData['ProductSale']);

            if(count($this->sale->products))
            {

                foreach($this->sale->products as $kp => $p)
                {
                    $product = [

                        'id' => $p->id

                    ];

                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( $p->pivot->quantity /*, $this->sale->store_id*/);

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

                    $addStockPack->addStock( $p->pivot->quantity );

                }

            }

            if(count( $saleData['ProductSale'] ))
            {

                foreach( $saleData['ProductSale'] as $kp => $p)
                {
                    $product = [

                        'id' => $kp

                    ];

                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p['quantity']) * (-1) /*, $saleData['store_id']*/ );

                }

            }

            if(count( $saleData['PackSale'] ))
            {

                foreach( $saleData['PackSale'] as $kp => $p)
                {

                    $pack = [

                        'id' => $kp

                    ];

                    $addStockPack = new PackManager( $pack );

                    $addStockPack->addStock( ($p['quantity']) * (-1) );

                }

            }


            $response = [
                'success' => true,
                'return_id' => $sale->id
            ];

        }
        else
        {

            $saleErrors = [];

            if($SaleValidator->getErrors())
                $saleErrors = $SaleValidator->getErrors()->toArray();

            $errors =  $saleErrors;

            if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) && $canCreateDelivery)
            {

                $deliveryErrors = [];

                $destinationErrors = [];

                if ($DeliveryValidator->getErrors()) {

                    $deliveryErrors = $DeliveryValidator->getErrors()->toArray();

                    foreach ($deliveryErrors as $k => $e) {

                        $deliveryErrors['delivery.' . $k] = $e;

                        unset($deliveryErrors[$k]);

                    }
                }

                if($newDestination)
                {
                    if ($DestinationValidator->getErrors()) {

                        $destinationErrors = $DestinationValidator->getErrors()->toArray();

                        foreach ($destinationErrors as $k => $e) {

                            $destinationErrors['delivery.destination.' . $k] = $e;

                            unset($destinationErrors[$k]);

                        }
                    }
                }

                $errors =  $saleErrors + $deliveryErrors + $destinationErrors;
            }



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

                        $addStockProduct->addStock($p->pivot->quantity /*, $this->sale->store_id*/);

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

        if($sale->sale_type == 'contado')
        {

            \Movement::create([
                'user_id' => \Auth::user()->id,
                'store_id' => $sale->store_id,
                'type' => 'delete',
                'entity' => 'Sale',
                'entity_id' => $sale->id,
                'amount_in' => 0,
                'amount_out' => $sale->subtotal,
                'date' => $sale->sale_date
            ]);

            //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id']);

        }

        return $sale->delete();

    }

    public function preparePackProductSale($saleData)
    {

        $saleData['ProductSale'] = (isset($saleData['ProductSale'])) ? $saleData['ProductSale'] : [];

        $saleData['PackSale'] = (isset($saleData['PackSale'])) ? $saleData['PackSale'] : [];

        $saleData['PacksProductsSale'] = $saleData['ProductSale'] + $saleData['PackSale'];

        return $saleData;

    }

    public function prepareData($saleData)
    {
        if(\Auth::user()->role->level_id == 1)
        {
            $saleData['employee_id'] = \Auth::user()->id;
        }


        $saleData['user_id'] = \Auth::user()->id;

        if(\Auth::user()->role->level_id >= 3)
        {
            if(\Session::has('current_store.id'))
            {
                $data['store_id'] = \Session::get('current_store.id');
            }

        }
        else
        {
            $data['store_id'] = \Auth::user()->store_id;
        }

        $storeKey = false;

        if(!empty($saleData['store_id']))
        {
            $store = \Store::find($saleData['store_id']);

            if($store)
            {
                $storeKey = $store->key;
            }
        }

        $saleData['sheet'] = $storeKey.'-'.$saleData['sheet'];

        $subtotal = 0;

        foreach($saleData['PackSale'] as $k => $p)
        {
            $pack = \Pack::find($k);

            $price = (float) $pack->price * $p['quantity'];

            $subtotal += $price;
        }

        foreach($saleData['ProductSale'] as $k => $p)
        {
            $product = \Product::find($k);

            $price = (float) $product->price * $p['quantity'];

            $subtotal += $price;
        }

        $commission_pay = 0;

        if($saleData['pay_type_id']) {

            $pay_type = \PayType::find($saleData['pay_type_id']);

            $commission_pay = ($subtotal / 100) * $pay_type->percent_commission;

        }

        $saleData['subtotal'] = $subtotal;

        $saleData['commission_pay'] = number_format($commission_pay, 2, '.', '');

        $saleData['total'] = number_format(($subtotal + $commission_pay), 2, '.', '');

        if(!isset($saleData['ColorProductSale']))
        {
            $saleData['ColorProductSale'] = [];
        }

        return $saleData;
    }

}

