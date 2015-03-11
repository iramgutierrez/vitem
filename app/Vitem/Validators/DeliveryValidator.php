<?php namespace Vitem\Validators;

class DeliveryValidator extends BaseValidator {

    protected $fromSale;
    
    protected $rules = array(
        'sale_id' => 'required|exists:sales,id|unique:deliveries,sale_id',
        'employee_id' => 'required|exists:employees,id',
        'user_id' => 'required|exists:users,id',
        'destination_id' => 'required|exists:destinations,id',
        'pay_type_id' => 'required|exists:pay_types,id',
        'total' => 'required',
        'commission_pay' => 'required',
        'subtotal' => 'required',
        'address'     => 'required',
        'delivery_date'     => 'required'
    );

    public function __construct(\Eloquent $model , $fromSale = false , $newDestination = false)
    {
        $this->model = $model;

        if($fromSale)
        {
            $this->updateRulesFromSale();
        }
        if($newDestination)
        {
            $this->updateRulesFromNewDestination();
        }
    }

    public function getUpdateRules()
    {
        $rules = $this->getRules();

        if (isset ($rules['sale_id']))
        {
            $rules['sale_id'] .= ',' . $this->model->id;

        }

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    public function updateRulesFromSale()
    {

        $rules = $this->getRules();

        unset($rules['sale_id']);

        $this->rules = $rules;

    }

    public function updateRulesFromNewDestination()
    {

        $rules = $this->getRules();

        unset($rules['destination_id']);

        $this->rules = $rules;

    }


    
    
}