<?php namespace Vitem\Validators;

class DeliveryValidator extends BaseValidator {
    
    protected $rules = array(
        'sale_id' => 'required|exists:sales,id|unique:deliveries,sale_id',
        'employee_id' => 'required|exists:employees,id',
        'user_id' => 'required|exists:users,id',
        'destination_id' => 'required|exists:destinations,id',
        'address'     => 'required',
        'delivery_date'     => 'required'
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();        

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}