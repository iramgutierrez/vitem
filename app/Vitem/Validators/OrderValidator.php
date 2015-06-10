<?php namespace Vitem\Validators;

class OrderValidator extends BaseValidator {
    
    protected $rules = array(
        'order_date'     => 'required',
        'supplier_id' => 'required|exists:suppliers,id',
        'user_id' => 'required|exists:users,id',
        'total' => 'required',
        'ProductOrder' => 'required|min:1'
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