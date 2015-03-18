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

            $store_id = $expenseData['store_id'];

            \Setting::checkSettingAndAddResidue('add_residue_new_expense', ( ($expenseData['quantity'])*(-1)  ) , $store_id );

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

        $store_old = $this->expense->store_id;

        $ExpenseValidator = new ExpenseValidator($this->expense);

        $expenseData = $this->prepareData($expenseData);

        $expenseValid  =  $ExpenseValidator->isValid($expenseData); 


        if( $expenseValid )
        {

            $expense = $this->expense;
            
            $expense->update($expenseData); 

            $store_id = $expense->store_id;

            \Setting::checkSettingAndAddResidue('add_residue_new_expense', $quantityOld , $store_old );

            \Setting::checkSettingAndAddResidue('add_residue_new_expense',  ( ($expenseData['quantity'])*(-1) ) , $store_id  );

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

        $store_id = $expense->store_id;

        \Setting::checkSettingAndAddResidue('add_residue_new_commission', $expense->quantity , $store_id );

        return $expense->delete();

    }

    public function prepareData($expenseData)
    {
        
        $expenseData['user_id'] = \Auth::user()->id;

         if(\Auth::user()->role->level_id >= 3)
        {
            if(\Session::has('current_store.id'))
            {
                $data['store_id'] = \Session::get('current_store.id');
            }

        }
        else
        {
            $data['store_id'] = \Auth::user()->store_id;
        }

        return $expenseData;

    }

} 