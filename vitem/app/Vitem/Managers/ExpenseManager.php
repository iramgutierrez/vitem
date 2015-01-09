<?php namespace Vitem\Managers;

use Vitem\Validators\ExpenseValidator;


class ExpenseManager extends BaseManager {

    protected $expense;

    
    public function save()
    {
        $ExpenseValidator = new ExpenseValidator(new \Expense);

        $expenseData = $this->data;  

        $expenseData = $this->prepareData($expenseData);
        
        $expenseValid  =  $ExpenseValidator->isValid($expenseData);

        if( $expenseValid )
        {

            $expense = new \Expense( $expenseData );
            
            $expense->save();

            \Setting::checkSettingAndAddResidue('add_residue_new_expense', ( ($expenseData['quantity'])*(-1)  ) );

            $response = [
                'success' => true,
                'return_id' => $expense->id
            ];            

        }
        else
        {
            
            $expenseErrors = [];

            if($ExpenseValidator->getErrors())
                $expenseErrors = $ExpenseValidator->getErrors()->toArray();            

            $errors =  $expenseErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $expenseData = $this->data;         

        $this->expense = \Expense::find($expenseData['id']);

        $quantityOld = $this->expense->quantity;

        $ExpenseValidator = new ExpenseValidator($this->expense);

        $expenseData = $this->prepareData($expenseData);

        $expenseValid  =  $ExpenseValidator->isValid($expenseData); 


        if( $expenseValid )
        {

            $expense = $this->expense;
            
            $expense->update($expenseData); 

            \Setting::checkSettingAndAddResidue('add_residue_new_expense', $quantityOld );

            \Setting::checkSettingAndAddResidue('add_residue_new_expense',  ( ($expenseData['quantity'])*(-1) )  );

            $response = [
                'success' => true,
                'return_id' => $expense->id
            ];            

        }
        else
        {
            
            $expenseErrors = [];

            if($ExpenseValidator->getErrors())
                $expenseErrors = $ExpenseValidator->getErrors()->toArray();            

            $errors =  $expenseErrors;

            

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $expenseData = $this->data; 

        $this->expense = \Expense::find($expenseData['id']);        

        $expense = $this->expense;

        \Setting::checkSettingAndAddResidue('add_residue_new_commission', $expense->quantity );

        return $expense->delete();

    }

    public function prepareData($expenseData)
    {
        
        $expenseData['user_id'] = \Auth::user()->id;

        return $expenseData;
    }

} 