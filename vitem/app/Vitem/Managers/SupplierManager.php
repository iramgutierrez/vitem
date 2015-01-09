<?php namespace Vitem\Managers;

use Vitem\Validators\SupplierValidator;


class SupplierManager extends BaseManager {

    protected $supplier;

    
    public function save()
    {
        $SupplierValidator = new SupplierValidator(new \Supplier);

        $supplierData = $this->data;  
        
        $supplierValid  =  $SupplierValidator->isValid($supplierData);

        if( $supplierValid )
        {
            $supplierData = $this->prepareData( $supplierData );

            $supplier = new \Supplier( $supplierData );
            
            $supplier->save();

            $response = [
                'success' => true,
                'return_id' => $supplier->id
            ];            

        }
        else
        {
            
            $supplierErrors = [];

            if($SupplierValidator->getErrors())
                $supplierErrors = $SupplierValidator->getErrors()->toArray();            

            $errors =  $supplierErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $supplierData = $this->data;    

        $this->supplier = \Supplier::find($supplierData['id']);

        $SupplierValidator = new SupplierValidator($this->supplier);


        $supplierData = $this->prepareData( $supplierData ); 

        $supplierValid  =  $SupplierValidator->isValid($supplierData);

        

        if( $supplierValid )
        {             

            $supplier = $this->supplier;

            $supplier->name = $supplierData['name'];

            $supplier->email = $supplierData['email'];

            $supplier->rfc = $supplierData['rfc'];

            $supplier->business_name = $supplierData['business_name'];

            $supplier->street = $supplierData['street'];

            $supplier->outer_number = $supplierData['outer_number'];

            $supplier->inner_number = $supplierData['inner_number'];

            $supplier->zip_code = $supplierData['zip_code'];

            $supplier->colony = $supplierData['colony'];

            $supplier->city = $supplierData['city'];

            $supplier->state = $supplierData['state'];

            $supplier->phone = $supplierData['phone'];       

            $supplier->status = $supplierData['status'];
            
            $supplier->save();

            $response = [
                'success' => true
            ];            

        }
        else
        {
            
            $supplierErrors = [];

            if($SupplierValidator->getErrors())
                $supplierErrors = $SupplierValidator->getErrors()->toArray();

            $errors =  $supplierErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

} 