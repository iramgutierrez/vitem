<?php namespace Vitem\Validators;

class UserValidator extends BaseValidator {
    
    protected $rules = array(
        'email'     => 'required|email|unique:users,email',
        'name' => 'required|min:4|max:40',
        'password'  => 'min:6|confirmed',
        'username' => 'required|min:4|max:40',
        'phone' => 'required',
        'street' => 'required',
        'inner_number' => 'required',
        'zip_code' => 'required',
        'role_id' => 'required',
        'image_profile'  => 'max:500',
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
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        if (isset ($rules['password']))
        {
            // Si el usuario no existe la clave es obligatoria:
            $rules['password'] .= '|required';
        }

        $this->rules = $rules;

        return $rules;
    }

    

    
    
}