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

            \Setting::checkSettingAndAddResidue('add_residue_new_commission', ( $commissionData['total']  ) );

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

        $totalOld = $this->commission->total;

        $CommissionValidator = new CommissionValidator($this->commission);

        $commissionData = $this->prepareData($commissionData);

        $commissionValid  =  $CommissionValidator->isValid($commissionData); 


        if( $commissionValid )
        {

            $commission = $this->commission;
            
            $commission->update($commissionData); 

            \Setting::checkSettingAndAddResidue('add_residue_new_commission', ( ($totalOld)*(-1)  ) );

            \Setting::checkSettingAndAddResidue('add_residue_new_commission',  $commissionData['total']  );

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

        \Setting::checkSettingAndAddResidue('add_residue_new_commission', ( ($commission->total)*(-1)  ) );

        return $commission->delete();

    }

    public function prepareData($commissionData)
    {
        
        $commissionData['user_id'] = \Auth::user()->id;

        return $commissionData;
    }

} 

