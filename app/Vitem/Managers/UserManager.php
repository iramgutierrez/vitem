<?php namespace Vitem\Managers;


use Vitem\Validators\UserValidator;
use Vitem\Validators\EmployeeValidator;


class UserManager extends BaseManager {

    protected $user;

    
    public function save()
    {
        $userValidator = new UserValidator(new \User);

        $employeeValidator = new EmployeeValidator(new \Employee);

        $userData = $this->data['User'];        

        $employeeData = $this->data['Employee'];

        $userData = $this->prepareData( $userData );
        
        $userValid  =  $userValidator->isValid($userData);

        $employeeValid = $employeeValidator->isValid($employeeData);

        if( $userValid && $employeeValid )
        {

            $user = new \User( $userData );
            
            $user->save();

            $employeeData['salary'] = (is_numeric($employeeData['salary'])) ? $employeeData['salary']: 0;

            $employeeData['entry_date'] = (!empty($employeeData['entry_date'])) ? $employeeData['entry_date']: '0000-00-00';

            //dd($employeeData);

            $employee = new \Employee ( $employeeData );

            $employee->users_id = $user->id;

            $employee->save();

            $response = [
                'success' => true
            ];            

        }
        else
        {
            
            $userErrors = [];

            $employeeErrors = [];

            if($userValidator->getErrors())
                $userErrors = $userValidator->getErrors()->toArray();

            if($employeeValidator->getErrors())
                $employeeErrors = $employeeValidator->getErrors()->toArray();

            $errors =  $userErrors + $employeeErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $userData = $this->data['User'];        

        $employeeData = $this->data['Employee'];

        $this->user = \User::find($userData['id']);

        $userValidator = new UserValidator($this->user);

        $employeeValidator = new EmployeeValidator($this->user->employee); 

        $userData = $this->prepareData( $userData ); 

        $userValid  =  $userValidator->isValid($userData);

        $employeeValid = $employeeValidator->isValid($employeeData);   

        

        if( $userValid && $employeeValid )
        {             

            $user = $this->user;

            $user->name = $userData['name'];

            $user->email = $userData['email'];

            $user->street = $userData['street'];

            $user->outer_number = $userData['outer_number'];

            $user->inner_number = $userData['inner_number'];

            $user->zip_code = $userData['zip_code'];

            $user->colony = $userData['colony'];

            $user->city = $userData['city'];

            $user->state = $userData['state'];

            $user->phone = $userData['phone'];

            $user->username = $userData['username'];

            if($userData['password'])
            {
                $user->password = $userData['password'];
            }            

            $user->role_id = $userData['role_id'];           

            $user->store_id = $userData['store_id'];

            $user->image_profile = $userData['image_profile'];

            //$user->status = $userData['status'];

            $user->employee->salary = $employeeData['salary'];

            $user->employee->entry_date = $employeeData['entry_date'];
            
            $user->save();
            
            $user->employee->save();

            $response = [
                'success' => true
            ];            

        }
        else
        {
            
            $userErrors = [];

            $employeeErrors = [];

            if($userValidator->getErrors())
                $userErrors = $userValidator->getErrors()->toArray();

            if($employeeValidator->getErrors())
                $employeeErrors = $employeeValidator->getErrors()->toArray();

            $errors =  $userErrors + $employeeErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function destroy()
    {

        $userData = $this->data;    

        $this->user = \User::find($userData['id']);

        $user = $this->user;

        $user->employee()->delete();         

        $user->delete();

        return [

            'success' => true
            
        ];

    }

    public function prepareData($data)
    {
        
        if(isset($data['image_profile']))
        {
            if(!is_object($data['image_profile']))
            { dd($this->user->image_profile);    
                
            }else
            {
                $filename = $data['username']. '_' . time(). '.' .$data['image_profile']->getClientOriginalExtension();

                if($data['image_profile']->move('images_profile', $filename))
                {
                    $data['image_profile'] = $filename;
                }

            }
        }else
        {
            if(isset($this->user->id))
            {
                $data['image_profile'] = $this->user->image_profile;
            }
        }

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

        return $data;
    }

} 