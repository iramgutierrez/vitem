<?php namespace Vitem\Validators;

class StoreValidator extends BaseValidator {
    
    protected $rules = array(
        'name'     => 'required',
        'email'     => 'required|email|unique:stores,email',
        'address'     => 'required',
        'phone'     => 'required',
        'user_id' => 'required|exists:users,id',
    );

    public function getUpdateRules()
    {
        $rules = $this->getRules();

        if ( isset ($rules['email']) )
        {

            $rules['email'] .= ',' . $this->model->id;

        }

        $this->rules = $rules;
        
        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}