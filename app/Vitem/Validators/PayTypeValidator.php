<?php namespace Vitem\Validators;

class PayTypeValidator extends BaseValidator {
    
    protected $rules = array(
        'name' => 'required',
        'percent_commission' => 'required|numeric',
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