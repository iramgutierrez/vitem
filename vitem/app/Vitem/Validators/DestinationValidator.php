<?php namespace Vitem\Validators;

class DestinationValidator extends BaseValidator {
    
    protected $rules = array(
        'type' => 'required',
        'cost' => 'required',
        'zip_code' => 'required_if:type,1',
        'colony' => 'required_if:type,2',
        'town' => 'required_if:type,3',
        'state' => 'required_if:type,4',
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