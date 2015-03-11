<?php namespace Vitem\Managers;


use Vitem\Validators\UserValidator;
use Vitem\Validators\EmployeeValidator;


class CreateUserManager extends BaseManager {

    
    public function save()
    {
        $userValidator = new UserValidator(new \User);
        $userValidator->getRulesForCreate();

        $employeeValidator = new EmployeeValidator(new \Employee);
        $employeeValidator->getRulesForCreate();

        $userData = $this->data['User'];        

        $employeeData = $this->data['Employee'];
        
        $userValid  =  $userValidator->isValid($userData);

        $employeeValid = $employeeValidator->isValid($employeeData);

        if( $userValid && $employeeValid )
        {
            $userData = $this->prepareData( $userData );

            $user = new \User( $userData );
            
            $user->save();

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

    public function prepareData($data)
    {
        if(isset($data['image_profile']))
        {
            $filename = $data['username']. '_' . time(). '.' .$data['image_profile']->getClientOriginalExtension();

            if($data['image_profile']->move('images_profile', $filename))
            {
                $data['image_profile'] = $filename;
            }

        }

        return $data;
    }

} 