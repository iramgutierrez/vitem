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

            \Movement::create([
                'user_id' => \Auth::user()->id,
                'store_id' => $expense->store_id,
                'type' => 'create',
                'entity' => 'Expense',
                'entity_id' => $expense->id,
                'amount_in' => 0,
                'amount_out' => $expense->quantity,
                'date' => $expense->date
            ]);

            //\Setting::checkSettingAndAddResidue('add_residue_new_expense', ( ($expenseData['quantity'])*(-1)  ) , $store_id );

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

        $storeOld = $this->expense->store_id;

        $dateOld = $this->expense->date;

        $ExpenseValidator = new ExpenseValidator($this->expense);

        $expenseData = $this->prepareData($expenseData);

        $expenseValid  =  $ExpenseValidator->isValid($expenseData);


        if( $expenseValid )
        {

            $expense = $this->expense;

            $expense->update($expenseData);

            if($storeOld == $expense->store_id && $dateOld == $expense->date)
            {
                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $expense->store_id,
                    'type' => 'update',
                    'entity' => 'Expense',
                    'entity_id' => $expense->id,
                    'amount_in' => $quantityOld,
                    'amount_out' => $expense->quantity,
                    'date' => $expense->date
                ]);
            }
            else
            {

                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $storeOld,
                    'type' => 'update',
                    'entity' => 'Expense',
                    'entity_id' => $expense->id,
                    'amount_in' => $quantityOld,
                    'amount_out' => 0,
                    'date' => $dateOld
                ]);


                \Movement::create([
                    'user_id' => \Auth::user()->id,
                    'store_id' => $expense->store_id,
                    'type' => 'update',
                    'entity' => 'Expense',
                    'entity_id' => $expense->id,
                    'amount_in' => 0,
                    'amount_out' => $expense->quantity,
                    'date' => $expense->date
                ]);

            }

            /*\Setting::checkSettingAndAddResidue('add_residue_new_expense', $quantityOld , $store_old );

            \Setting::checkSettingAndAddResidue('add_residue_new_expense',  ( ($expenseData['quantity'])*(-1) ) , $store_id  );*/

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

        \Movement::create([
            'user_id' => \Auth::user()->id,
            'store_id' => $expense->store_id,
            'type' => 'delete',
            'entity' => 'Expense',
            'entity_id' => $expense->id,
            'amount_in' => $expense->quantity,
            'amount_out' => 0,
            'date' => $expense->date
        ]);

        //\Setting::checkSettingAndAddResidue('add_residue_new_commission', $expense->quantity , $store_id );

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