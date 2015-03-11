<?php namespace Vitem\Validators;

class SaleValidator extends BaseValidator {
    
    protected $rules = array(
        'sheet'     => 'required|unique:sales,sheet',
        'sale_type' => 'required',
        'down_payment' => 'required_if:sale_type,apartado',
        'sale_date' => 'required',
        'pay_type_id' => 'required|exists:pay_types,id',
        'employee_id' => 'required|exists:employees,id',
        'user_id' => 'required|exists:users,id',
        'client_id' => 'required|exists:clients,id',
        'total' => 'required',
        'PacksProductsSale' => 'required|min:1'
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();

        if (isset ($rules['sheet']))
        { 
            // Si el usuario existe: Excluimos su ID de la regla "unique" (definida al final de la cadena)
            $rules['sheet'] .= ',' . $this->model->id;
        }

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}