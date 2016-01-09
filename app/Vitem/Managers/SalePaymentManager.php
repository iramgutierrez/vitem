<?php namespace Vitem\Managers;

use Vitem\Validators\SalePaymentValidator;


class SalePaymentManager extends BaseManager {

    protected $salePayment;


    public function save()
    {
        $SalePaymentValidator = new SalePaymentValidator(new \SalePayment);

        $salePaymentData = $this->data;

        if(isset($salePaymentData['sheet']))
        {
            $sale = \Sale::where('sheet' , $salePaymentData['sheet'])->first();


        }
        else if(isset($salePaymentData['sale_id']))
        {
            $sale = \Sale::find($salePaymentData['sale_id']);
        }

        $salePaymentData['sale_id'] = (isset($sale->id)) ? $sale->id : false;

        $salePaymentData = $this->prepareData($salePaymentData);

        $salePaymentValid  =  $SalePaymentValidator->isValid($salePaymentData);
        if( $salePaymentValid )
        {

            $salePayment = new \SalePayment( $salePaymentData );

            $salePayment->save();

            \Movement::create([
                'user_id' => (\Auth::check()) ? \Auth::user()->id : $salePayment->user_id,
                'store_id' => $salePayment->sale->store_id,
                'type' => 'create',
                'entity' => 'SalePayment',
                'entity_id' => $salePayment->id,
                'amount_in' => $salePayment->total,
                'amount_out' => 0,
                'date' => $salePayment->date
            ]);

            //\Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', $salePaymentData['total'] , $sale->store_id );

            $response = [
                'success' => true,
                'sale_id' => $salePayment->sale_id,
                'return_id' => $salePayment->id
            ];

        }
        else
        {

            $salePaymentErrors = [];

            if($SalePaymentValidator->getErrors())
                $salePaymentErrors = $SalePaymentValidator->getErrors()->toArray();

            $errors =  $salePaymentErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update($store_id = false)
    {

        $salePaymentData = $this->data;

        $this->salePayment = \SalePayment::find($salePaymentData['id']);

        $quantityOld = $this->salePayment->total;

        $dateOld = $this->salePayment->date;

        $store_id = $this->salePayment->sale->store_id;

        $store_old = (!empty($salePaymentData['store_id_old'])) ? $salePaymentData['store_id_old'] : $store_id;

        $SalePaymentValidator = new SalePaymentValidator($this->salePayment);

        $salePaymentData['user_id'] = \Auth::user()->id;

        $salePaymentData = $this->prepareData($salePaymentData);

        $salePaymentData['date'] .= ' 00:00:00';

        $salePaymentValid  =  $SalePaymentValidator->isValid($salePaymentData);

        if( $salePaymentValid )
        {

            $salePayment = $this->salePayment;

            $salePayment->update($salePaymentData);

            if($dateOld == $salePaymentData['date'])
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $salePayment->sale->store_id,
                    'type' => 'update',
                    'entity' => 'SalePayment',
                    'entity_id' => $salePayment->id,
                    'amount_in' => $salePayment->total,
                    'amount_out' => $quantityOld,
                    'date' => $salePayment->date
                ]);
            }
            else
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $store_old,
                    'type' => 'update',
                    'entity' => 'SalePayment',
                    'entity_id' => $salePayment->id,
                    'amount_in' => 0,
                    'amount_out' => $quantityOld,
                    'date' => $dateOld
                ]);

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $salePayment->sale->store_id,
                    'type' => 'update',
                    'entity' => 'SalePayment',
                    'entity_id' => $salePayment->id,
                    'amount_in' => $salePayment->total,
                    'amount_out' => 0,
                    'date' => $salePayment->date
                ]);
            }

            //\Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( ($quantityOld)*(-1)  ) , $store_old );

            //\Setting::checkSettingAndAddResidue('add_residue_new_sale_payment',  $salePaymentData['total'] , $store_id  );

            $response = [
                'success' => true
            ];

        }
        else
        {

            $salePaymentErrors = [];

            if($SalePaymentValidator->getErrors())
                $salePaymentErrors = $SalePaymentValidator->getErrors()->toArray();

            $errors =  $salePaymentErrors;

            dd($errors);

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $salePaymentData = $this->data;

        $this->salePayment = \SalePayment::find($salePaymentData['id']);

        $salePayment = $this->salePayment;

        $store_id = $salePayment->sale->store_id;

        \Movement::create([
            'user_id' => \Auth::user()->id,
            'store_id' => $salePayment->sale->store_id,
            'type' => 'delete',
            'entity' => 'SalePayment',
            'entity_id' => $salePayment->id,
            'amount_in' => 0,
            'amount_out' => $salePayment->total,
            'date' => $salePayment->date
        ]);

        //\Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( ($salePayment->subtotal)*(-1)  ) , $store_id );

        return $salePayment->delete();

    }



    public function prepareData($salePaymentData)
    {
        if(empty($salePaymentData['access_token']) && empty($salePaymentData['user_id']))
        {
            $salePaymentData['user_id'] = \Auth::user()->id;

        }

        $total = $salePaymentData['subtotal'];

        $commission_pay = 0;

        if($salePaymentData['pay_type_id']) {

            $pay_type = \PayType::find($salePaymentData['pay_type_id']);

            $commission_pay = ($total / 100) * $pay_type->percent_commission;

        }

        $salePaymentData['commission_pay'] = number_format($commission_pay, 2, '.', '');

        $salePaymentData['subtotal'] = number_format($total, 2, '.', '');

        $salePaymentData['total'] = number_format(($total + $commission_pay), 2, '.', '');

        return $salePaymentData;
    }

}