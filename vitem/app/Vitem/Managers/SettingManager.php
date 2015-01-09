<?php namespace Vitem\Managers;


class SettingManager extends BaseManager {

    protected $setting;

    
    public function save()
    {
        
        $settingData = $this->data; 

        $settingData = $this->prepareData($settingData);

        $checkExists = \Setting::firstOrCreate(['key' => $settingData['key']] );

        $checkExists->update($settingData);

        return [

            'success' => true

        ];        

    }

    public function saveAll()
    { 

        $settingsData = $this->data;

        $response = [];

        foreach($settingsData as $settingKey => $settingData)
        {

            if($settingKey != '_token')
            {

                $setting = [
                    'key' => $settingKey,
                    'value' => $settingData
                ];

                $this->data = $setting;

                $response_setting = $this->save();

                if(isset( $response[$response_setting['success']] ) )
                {

                    $response[$response_setting['success']]++;

                }
                else
                {

                    $response[$response_setting['success']] = 1;

                }

            }

        } 

        return $response;

    }

    public function update()
    {

        $commissionData = $this->data; 

        

        $this->commission = \Commission::find($commissionData['id']);

        $CommissionValidator = new CommissionValidator($this->commission);

        $commissionData = $this->prepareData($commissionData);

        $commissionValid  =  $CommissionValidator->isValid($commissionData); 


        if( $commissionValid )
        {

            $commission = $this->commission;
            
            $commission->update($commissionData); 

            if($commission->type == 'sale_payments')
            {

                $commission->sale_payments()->sync($commissionData['SalePayment']);

            } else
            {

                $commission->sale_payments()->detach();

            }

            $response = [
                'success' => true,
                'return_id' => $commission->id
            ];            

        }
        else
        {
            
            $commissionErrors = [];

            if($CommissionValidator->getErrors())
                $commissionErrors = $CommissionValidator->getErrors()->toArray();            

            $errors =  $commissionErrors;

            

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

    public function prepareData($settingData)
    {
        
        $settingData['user_id'] = \Auth::user()->id;

        return $settingData;
    }

} 

