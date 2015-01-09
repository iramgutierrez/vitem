<?php namespace Vitem\Managers;

use Vitem\Validators\SaleValidator;
use Vitem\Managers\ProductManager;
use Vitem\Managers\PackManager;
use Vitem\Managers\SalePaymentManager;
use Vitem\Managers\DeliveryManager;
use Vitem\Validators\DeliveryValidator;


class SaleManager extends BaseManager {

    protected $sale;

    
    public function save()
    {
        $SaleValidator = new SaleValidator(new \Sale);

        $saleData = $this->data; 

        $saleData = $this->preparePackProductSale($saleData);

        $saleData = $this->prepareData($saleData);

        $saleValid  =  $SaleValidator->isValid($saleData); 

        /*$DeliveryValidator = new DeliveryValidator(new \Delivery);

        $deliveryValid = true;

            if($saleData['delivery_type'] == 1 && isset($saleData['delivery']) && is_array($saleData['delivery']) )
            {

                $deliveryValid  =  $DeliveryValidator->isValid($saleData['delivery']);
                    
            }

        if( $saleValid && $deliveryValid)*/

        if( $saleValid )
        {

                 
            $sale = new \Sale( $saleData ); 
            
            $sale->save(); 

            if($saleData['sale_type'] == 'contado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['total']);

            }

            $sale->packs()->sync($saleData['PackSale']);

            $sale->products()->sync($saleData['ProductSale']);

            if($saleData['sale_type'] == 'apartado')
            {

                $salePaymentData = [

                    'quantity' => $saleData['down_payment'],

                    'sale_id' => $sale->id,

                    'employee_id' => $sale->employee_id,

                    'pay_type' => $sale->pay_type
                ];

                $addSalePayment = new SalePaymentManager( $salePaymentData );

                $addSalePayment->save();

            }

            if(count( $saleData['ProductSale'] ))
            {

                foreach( $saleData['ProductSale'] as $kp => $p)
                {
                    $product = [

                        'id' => $kp

                    ];
                        
                    $addStockProduct = new ProductManager( $product );

                    $addStockProduct->addStock( ($p['quantity']) * (-1) );

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

            /*$deliveryErrors = [];

            if($SaleValidator->getErrors())
                $saleErrors = $SaleValidator->getErrors()->toArray();  

            if($DeliveryValidator->getErrors()){

                $deliveryErrors = $DeliveryValidator->getErrors()->toArray();

                foreach($deliveryErrors as $k => $e)
                {

                    $deliveryErrors['delivery.'.$k] = $e;

                    unset($deliveryErrors[$k]);

                } 
            }          

            $errors =  $saleErrors + $deliveryErrors; */

            $errors =  $saleErrors;

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
                     ->with(['employee' , 'employee.user' , 'sale_payments'])
                     ->find($saleData['id']);

        $saleTypeOld = $this->sale->sale_type;

        $totalOld = $this->sale->total;

        $SaleValidator = new SaleValidator($this->sale);

        $saleData = $this->preparePackProductSale($saleData);

        $saleData = $this->prepareData($saleData);

        $saleValid  =  $SaleValidator->isValid($saleData); 

        if( $saleValid )
        {

            $sale = $this->sale;

            $saleOld = $this->sale;
            
            $sale->update($saleData); 

            if($sale->sale_type == 'apartado')
            {

                $sale_payment = \SalePayment::where('sale_id' , $sale->id)->first();

                if($sale_payment)
                {
                    $salePaymentData = [

                        'quantity' => $saleData['down_payment'],

                        'id' => $sale_payment->id,

                        'sale_id' => $sale->id,

                        'employee_id' => $sale->employee_id,

                        'pay_type' => $sale->pay_type
                    ];

                    $addSalePayment = new SalePaymentManager( $salePaymentData );

                    $addSalePayment->update();

                }
                else
                {
                    $salePaymentData = [

                        'quantity' => $saleData['down_payment'],

                        'sale_id' => $sale->id,

                        'employee_id' => $sale->employee_id,

                        'pay_type' => $sale->pay_type
                    ];

                    $addSalePayment = new SalePaymentManager( $salePaymentData );

                    $addSalePayment->save();

                }



            }

            if($saleTypeOld == 'contado' && $sale->sale_type == 'apartado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1)  );

            }elseif($saleTypeOld == 'contado' && $sale->sale_type == 'contado'){

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1)  );

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['total'] );

            }elseif($saleTypeOld == 'apartado' && $sale->sale_type == 'contado'){

                foreach($sale->sale_payments as $sale_payment)
                {
                    $salePaymentData = [

                        'id' => $sale_payment->id

                    ];

                    $deleteSalePayment = new SalePaymentManager( $salePaymentData );

                    $deleteSalePayment->delete();
                }

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['total'] );

            }
            /*if($saleOld['sale_type'] == 'contado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['total']);

            }
            elseif($saleData['sale_type'] == 'apartado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['down_payment']);


            }*/



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

                    $addStockProduct->addStock( $p->pivot->quantity );

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

                    $addStockProduct->addStock( ($p['quantity']) * (-1) );

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

    public function preparePackProductSale($saleData)
    {       

        $saleData['ProductSale'] = (isset($saleData['ProductSale'])) ? $saleData['ProductSale'] : [];

        $saleData['PackSale'] = (isset($saleData['PackSale'])) ? $saleData['PackSale'] : [];

        $saleData['PacksProductsSale'] = $saleData['ProductSale'] + $saleData['PackSale'];

        return $saleData;

    }

    public function prepareData($saleData)
    {
        
        $saleData['user_id'] = \Auth::user()->id;

        $saleData['store_id'] = 1;

        $total = 0;

        foreach($saleData['PackSale'] as $k => $p)
        {
            $pack = \Pack::find($k);

            $price = (float) $pack->price * $p['quantity'];

            $total += $price;
        }

        foreach($saleData['ProductSale'] as $k => $p)
        {
            $product = \Product::find($k);

            $price = (float) $product->price * $p['quantity'];

            $total += $price;
        }

        $saleData['total'] = $total;

        return $saleData;
    }

} 

