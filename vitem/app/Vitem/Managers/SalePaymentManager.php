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

        $salePaymentData['user_id'] = \Auth::user()->id;
        
        $salePaymentValid  =  $SalePaymentValidator->isValid($salePaymentData);

        if( $salePaymentValid )
        {

            $salePayment = new \SalePayment( $salePaymentData );
            
            $salePayment->save();

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( $salePaymentData['quantity']  ) );

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

        $quantityOld = $this->salePayment->quantity;

        $SalePaymentValidator = new SalePaymentValidator($this->salePayment);

        $salePaymentData['user_id'] = \Auth::user()->id;

        $salePaymentValid  =  $SalePaymentValidator->isValid($salePaymentData);

        if( $salePaymentValid )
        {             

            $salePayment = $this->salePayment;

            $salePayment->employee_id = $salePaymentData['employee_id'];

            $salePayment->user_id = $salePaymentData['user_id'];

            $salePayment->quantity = $salePaymentData['quantity'];
            
            $salePayment->save();

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment', ( ($quantityOld)*(-1)  ) );

            \Setting::checkSettingAndAddResidue('add_residue_new_sale_payment',  $salePaymentData['quantity']  );
            
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

} 