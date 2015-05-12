<?php namespace Vitem\Managers;

use Vitem\Validators\ExpenseTypeValidator;


class ExpenseTypeManager extends BaseManager {

    protected $expense_type;

    
    public function save()
    {
        $ExpenseTypeValidator = new ExpenseTypeValidator(new \ExpenseType);

        $expenseTypeData = $this->data; 

        $expenseTypeData = $this->prepareData($expenseTypeData);

        $expenseTypeValid  =  $ExpenseTypeValidator->isValid($expenseTypeData);

        if( $expenseTypeValid )
        {

            if(!empty($expenseTypeData['id']))
            {
                $expenseType = \ExpenseType::find($expenseTypeData['id']);

                if($expenseType)
                {
                    unset($expenseTypeData['id']);

                    $expenseType->update($expenseTypeData);
                }

            }
            else
            {
                $expenseType = new \expenseType( $expenseTypeData ); 
            
                $expenseType->save(); 

            }
            
            

            $response = [
                'success' => true,
                'return_id' => $expenseType->id,
                'expense_type' => $expenseType
            ];            

        }
        else
        {
            
            $expenseTypeErrors = [];

            if($ExpenseTypeValidator->getErrors())
                $expenseTypeErrors = $ExpenseTypeValidator->getErrors()->toArray();            

            $errors =  $expenseTypeErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {
    }

    public function delete()
    {

        

    }

    public function prepareData($expenseTypeData)
    {
        
        $expenseTypeData['user_id'] = \Auth::user()->id;

        $expenseTypeData['slug'] = \Str::slug($expenseTypeData['name']);

        return $expenseTypeData;
    }

} 

