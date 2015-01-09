<?php namespace Vitem\Validators;

class SalePaymentValidator extends BaseValidator {
    
    protected $rules = array(
        'user_id'     => 'required',
        'sale_id'     => 'required|exists:sales,id',
        'employee_id'     => 'required',
        'quantity' => 'required',
        'pay_type' => 'required',
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