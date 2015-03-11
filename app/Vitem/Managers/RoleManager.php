<?php namespace Vitem\Managers;

use Vitem\Validators\RoleValidator;


class RoleManager extends BaseManager {

    protected $role;

    
    public function save()
    {
        $RoleValidator = new RoleValidator(new \Destination);

        $roleData = $this->data; 

        $roleData = $this->prepareData($roleData);
        
        $roleValid  =  $RoleValidator->isValid($roleData);

        if( $roleValid )
        {
            
            $role = new \Role( $roleData ); 
            
            $role->save(); 

            $role->Permission()->saveMany($roleData['Permission']);

            $response = [
                'success' => true,
                'return_id' => $role->id
            ];            

        }
        else
        {
            
            $roleErrors = [];

            if($RoleValidator->getErrors())
                $roleErrors = $RoleValidator->getErrors()->toArray();            

            $errors =  $roleErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {

        $roleData = $this->data;         

        $this->role = \Role::find($roleData['id']);

        $RoleValidator = new RoleValidator($this->role);

        $roleData = $this->prepareData($roleData);

        $roleValid  =  $RoleValidator->isValid($roleData); 


        if( $roleValid )
        {

            $role = $this->role;
            
            $role->update($roleData); 

            $role->Permission()->delete();

            $role->Permission()->saveMany($roleData['Permission']);

            $response = [
                'success' => true,
                'return_id' => $role->id
            ];            

        }
        else
        {
            
            $roleErrors = [];

            if($RoleValidator->getErrors())
                $roleErrors = $RoleValidator->getErrors()->toArray();            

            $errors =  $roleErrors;            

            $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function delete()
    {

        $roleData = $this->data; 

        $this->role = \Role::with('permission')

                           ->find($roleData['id']);

        if($this->role)
        { 
            $role = $this->role;

            $role->Permission()->delete();

            return $role->delete();

        }

        return false;        

    }

    public function prepareData($roleData)
    {
        
        $roleData['slug'] = \Str::slug($roleData['name']);

        $permissions = [];

        if(isset($roleData['Permission']))
        {

            foreach($roleData['Permission'] as $action => $entities)
            {

                foreach($entities as $entity => $value)
                {

                    $permissions[] = new \Permission([

                        //'role_id' => $roleData['id'],

                        'action_id' => $action ,

                        'entity_id' => $entity

                    ]);

                }

            }

            $roleData['Permission'] = $permissions;

        }

        return $roleData;
    }

} 

