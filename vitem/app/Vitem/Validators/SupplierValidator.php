<?php namespace Vitem\Validators;

class SupplierValidator extends BaseValidator {
    
    protected $rules = array(
        'email'     => 'required|email|unique:clients,email',
        'name' => 'required|min:4|max:40',
        'street' => 'required',
        'outer_number' => 'required',
        'zip_code' => 'required',
        'phone' => 'required',
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();


        
        if (isset ($rules['email']))
        { 
            // Si el usuario existe: Excluimos su ID de la regla "unique" (definida al final de la cadena)
            $rules['email'] .= ',' . $this->model->id;
        }

        $this->rules = $rules;

        return $rules;
    }

    

    
    
}