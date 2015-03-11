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

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( $salePaymentData['total']  ) );

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

    public function update()
    {

        $salePaymentData = $this->data;    

        $this->salePayment = \SalePayment::find($salePaymentData['id']);

        $quantityOld = $this->salePayment->subtotal;

        $SalePaymentValidator = new SalePaymentValidator($this->salePayment);

        $salePaymentData['user_id'] = \Auth::user()->id;

        $salePaymentData = $this->prepareData($salePaymentData);

        $salePaymentValid  =  $SalePaymentValidator->isValid($salePaymentData);

        if( $salePaymentValid )
        {             

            $salePayment = $this->salePayment;

            $salePayment->update();

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( ($quantityOld)*(-1)  ) );

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment',  $salePaymentData['subtotal']  );
            
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

        \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( ($salePayment->quantity)*(-1)  ) );

        return $salePayment->delete();

    }



    public function prepareData($salePaymentData)
    {

        $salePaymentData['user_id'] = \Auth::user()->id;

        $subtotal = $salePaymentData['subtotal'];

        $commission_pay = 0;

        if($salePaymentData['pay_type_id']) {

            $pay_type = \PayType::find($salePaymentData['pay_type_id']);

            $commission_pay = ($subtotal / 100) * $pay_type->percent_commission;

        }

        $salePaymentData['commission_pay'] = number_format($commission_pay, 2, '.', '');

        $salePaymentData['total'] = number_format(($subtotal - $commission_pay), 2, '.', '');

        return $salePaymentData;
    }

} 