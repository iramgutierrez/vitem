<?php namespace Vitem\Repositories;



use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepo {

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract public function getModel();



    public function get($params)
    {


        foreach($params as $method => $param)
        {

            $this->model = $this->model->$method($param);

        }


        $whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $this->model = $this->model->whereIn( 'user_id' , $whereUserId);



        return $this->model->get();

    }

    static function generateWith($entity , $relations , $field)
    {

        $usersPermitted = \ACLFilter::generateAuthCondition();

        $return = $entity::with(self::with($relations));

        if(count($usersPermitted))
        {
            $return->whereIn($field , $usersPermitted);
        }
    }



    static function with($entities )
    { 

        $with = [];

        foreach($entities as $k => $e)
        {
            $relationship = $e;

            $entityArray = explode('.' , $e );

            $resultEntity = [];

            foreach($entityArray as $k1 => $e1)
            {

                $entity = $e1;

                $entityClass = ucfirst( camel_case( str_singular($entity) ) );

                $is_employee = false;

                if($entityClass == 'Employee')
                {

                    $entityClass = 'User';

                    $is_employee = true;

                }
                else if($entityClass == 'PayType')
                {

                    $entityClass = 'Sale';

                }
                else if($entityClass == 'ExpenseType')
                {

                    $entityClass = 'Expense';

                }
                else if($entityClass == 'ColorsProduct')
                {

                    $entityClass = 'Color';

                }

                $permitted = PermissionRepo::checkAuth($entityClass , 'Read' );

                if($permitted)
                {
                    $resultEntity[$entity] = true;

                }
                else
                {
                    break;
                }

            }

            if(count($resultEntity))
            {

                $with[] = implode('.' ,array_keys($resultEntity) );

            }



        }
        return $with;

    }

    public function find($id)
    {
        $record = $this->model;

        $whereUserId = \ACLFilter::generateAuthCondition();

        if(count($whereUserId))
            $record = $record->whereIn( 'employee_id'  , function ($query) use ($whereUserId) {

                $query->select(\DB::raw('id'))
                    ->from('employees')
                    ->whereIn('employees.users_id', $whereUserId);

            });

        $record = $record->find($id);

        return $record;
    }


}