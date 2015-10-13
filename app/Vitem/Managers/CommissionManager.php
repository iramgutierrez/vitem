<?php namespace Vitem\Managers;

use Vitem\Validators\CommissionValidator;


class CommissionManager extends BaseManager {

    protected $commission;


    public function save()
    {
        $CommissionValidator = new CommissionValidator(new \Commission);

        $commissionData = $this->data;

        $commissionData = $this->prepareData($commissionData);

        $commissionValid  =  $CommissionValidator->isValid($commissionData);

        if( $commissionValid )
        {

            $commission = new \Commission( $commissionData );

            $commission->save();

            $store_id = $commission->sale->store_id;

            if($commission->status_pay == 'pagado')
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $commission->sale->store_id,
                    'type' => 'create',
                    'entity' => 'Commission',
                    'entity_id' => $commission->id,
                    'amount_in' => 0,
                    'amount_out' => $commission->total,
                    'date' => $commission->date
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_commission', ( $commissionData['total']*(-1)  ) , $store_id );

            }
            if($commission->type == 'sale_payments')
            {

                $commission->sale_payments()->sync($commissionData['SalePayment']);

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

    public function saveAll()
    {

        $commissionsData = $this->data['Commissions'];

        //print_r($commissionsData); exit();

        $response = [];

        foreach($commissionsData as $commissionData)
        {

            $this->data = $commissionData;

            $response_commission = $this->save();

            if(isset( $response[$response_commission['success']] ) )
            {

                $response[$response_commission['success']]++;

            }
            else
            {

                $response[$response_commission['success']] = 1;

            }

        }

        return $response;

    }

    public function update()
    {

        $commissionData = $this->data;

        $this->commission = \Commission::find($commissionData['id']);

        $commissionOld = $this->commission;

        $totalOld = $this->commission->total;

        $dateOld = $this->commission->date;

        $storeOld = $this->commission->sale->store_id;

        $CommissionValidator = new CommissionValidator($this->commission);

        $commissionData = $this->prepareData($commissionData);

        $commissionData['date'] .= ' 00:00:00';

        $commissionValid  =  $CommissionValidator->isValid($commissionData);


        if( $commissionValid )
        {

            $commission = $this->commission;

            $store_id = $commission->sale->store_id;

            $commission->update($commissionData);

            if($commissionOld->status_pay == 'pagado' && $commissionData['status_pay'] == 'pendiente')
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $commission->sale->store_id,
                    'type' => 'update',
                    'entity' => 'Commission',
                    'entity_id' => $commission->id,
                    'amount_in' => $totalOld,
                    'amount_out' => 0,
                    'date' => $dateOld
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1) , $saleOld->store_id );

            }elseif($commissionOld->status_pay == 'pagado' && $commissionData['status_pay'] == 'pagado'){

                if($dateOld == $commission->date && $storeOld == $commission->sale->store_id)
                {
                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $commission->sale->store_id,
                        'type' => 'update',
                        'entity' => 'Commission',
                        'entity_id' => $commission->id,
                        'amount_in' => $totalOld,
                        'amount_out' => $commission->total,
                        'date' => $commission->date
                    ]);
                }
                else
                {

                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $storeOld,
                        'type' => 'update',
                        'entity' => 'Commission',
                        'entity_id' => $commission->id,
                        'amount_in' => $totalOld,
                        'amount_out' => 0,
                        'date' => $dateOld
                    ]);

                    \Movement::create([
                        'user_id' => \Auth::user()->id,
                        'store_id' => $commission->sale->store_id,
                        'type' => 'update',
                        'entity' => 'Commission',
                        'entity_id' => $commission->id,
                        'amount_in' => 0,
                        'amount_out' => $commission->total,
                        'date' => $commission->date
                    ]);
                }


                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', ($totalOld)*(-1) , $saleOld->store_id );

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id'] );

            }elseif($commissionOld->status_pay == 'pendiente' && $commissionData['status_pay'] == 'pagado'){

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $commission->sale->store_id,
                    'type' => 'update',
                    'entity' => 'Commission',
                    'entity_id' => $commission->id,
                    'amount_in' => 0,
                    'amount_out' => $commission->total,
                    'date' => $commission->date
                ]);

                //\Setting::checkSettingAndAddResidue('add_residue_new_sale', $saleData['subtotal'] , $saleData['store_id'] );

            }

            /*if($commissionOld->status_pay == 'pagado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_commission', ( ($totalOld)  ) , $store_id );

            }
            if($commissionData['status_pay'] == 'pagado')
            {

                \Setting::checkSettingAndAddResidue('add_residue_new_commission',  ($commissionData['total'] *(-1)), $store_id  );

            }*/

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

        $commissionData = $this->data;

        $this->commission = \Commission::find($commissionData['id']);

        $commission = $this->commission;

        $store_id = $commission->sale->store_id;

        if($commission->status_pay == 'pagado')
        {

            \Movement::create([
                'user_id' => \Auth::user()->id,
                'store_id' => $commission->sale->store_id,
                'type' => 'delete',
                'entity' => 'Commission',
                'entity_id' => $commission->id,
                'amount_in' => $commission->total,
                'amount_out' => 0,
                'date' => $commission->date
            ]);

            //\Setting::checkSettingAndAddResidue('add_residue_new_commission', ( ($commission->total)  ) , $store_id );

        }

        return $commission->delete();

    }

    public function prepareData($commissionData)
    {

        $commissionData['user_id'] = \Auth::user()->id;

        return $commissionData;
    }

}

