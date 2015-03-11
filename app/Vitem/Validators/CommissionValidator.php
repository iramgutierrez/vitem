<?php namespace Vitem\Validators;

class CommissionValidator extends BaseValidator {
    
    protected $rules = array(
        'sale_id' => 'required|exists:sales,id',
        'employee_id' => 'required|exists:employees,id',
        'user_id' => 'required|exists:users,id',
        'type'     => 'required',
        'total_commission'     => 'required',
        'total'     => 'required',
        'percent' => 'required',
        'SalePayment' => 'required_if:type,sale_payments|min:1'
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