(function () {

  angular.module('expenses.controllers', [])

    .controller('ExpensesController', ['$scope', '$filter' , 'ExpensesService', function ($scope ,  $filter , ExpensesService) {
        
        $scope.find = '';   
        $scope.type = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        /*Generar XLS */

        $scope.filename = 'reporte_entregas';

        $scope.dataExport = false;

        $scope.headersExport = JSON.stringify([
          {
            field : 'id',
            label : 'Id'
          },
          {
            field : {
              employee: {
                user : 'name'
              }
            },
            label : 'Empleado'
          },
          {
            field : {
              store: 'name'
            },
            label : 'Sucursal'
          },
          {
            field : {
              expense_type: 'name'
            },
            label : 'Tipo de gasto'
          },
          {
            field : 'date',
            label : 'Fecha'
          },
          {
            field : 'concept',
            label : 'Concepto'
          },
          {
            field : 'description',
            label : 'Descripción'
          },
          {
            field : 'quantity',
            label : 'Cantidad'
          },
        ]);   

        $scope.generateJSONDataExport = function( data )
        { 

          return JSON.stringify(data);

        }

        /*Generar XLS */

        $scope.init = function() 
        { 
          
          ExpensesService.API(

            'find',
            {              
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              type : $scope.type , 

            }).then(function (data) {              

                $scope.expensesP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });  

        }

        $scope.init();

        ExpensesService.all().then(function (data) {

          $scope.expensesAll = data;

          $scope.expenses = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.expenses);  

          /*Generar XLS */      

          $scope.search(true);

          $scope.paginate();     

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);   

            if(!$scope.expensesAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.expenses.length;          

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.expensesP = $scope.expenses.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.expensesP = $scope.expenses;
          }
        }



        $scope.search = function ( init )
        { 

          if(!$scope.expensesAll)
          {
          
            $scope.init();

          }
          else
          {
          
            $scope.expenses = ExpensesService.search($scope.find , $scope.expensesAll , $scope.type );

            /*Generar XLS */

            $scope.dataExport = $scope.generateJSONDataExport($scope.expenses);  

            /*Generar XLS */      
            
          }

          if(!init){

            $scope.paginate(1);

          }

        }

        $scope.clear = function () 
        {
          $scope.find = '';   
          $scope.type = '';
          $scope.sort = 'id';
          $scope.reverse = false;
          $scope.expenses = $scope.expensesAll;
          $scope.paginate(1);
          $scope.modal = false;

        }

    }])

    .controller('FormController', [ '$scope' , 'UsersService' , function ($scope , UsersService) {

      $scope.dateOptions = {

            dateFormat: "yy-mm-dd",
            prevText: '<',
            nextText: '>',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                    'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'MIercoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],

      };

      $scope.find_employee = '';

      $scope.autocompleteEmployee = false;

      $scope.employees = {};

      UsersService.all().then(function (data) {

            $scope.employeesAll = data;

      });

      $scope.getUsersByStore = function()
      {

        var store_id = $scope.store_id || false;

        UsersService.API('all',{ store_id : store_id }).then(function (data) {

          $scope.employeesAll = data;

        });
      }


      $scope.changeStore = function ()
      {

          $scope.getUsersByStore();

          $scope.employee_id = '';
          
          $scope.find_employee = '';

          $scope.autocompleteEmployee = false;

      }

      $scope.searchEmployee = function ()
      {           
            if($scope.find_employee.length != '')
            {
                $scope.employees = UsersService.search($scope.find_employee , $scope.employeesAll , false , 1 , false , false , false , false );

                $scope.autocompleteEmployee = true;

            }else{

                $scope.employees = {};

                $scope.autocompleteEmployee = false;


            }
            

      }        

      $scope.addEmployee = function(employee)
      { 

      
            $scope.employee_id = employee.employee.id;

            $scope.find_employee = employee.name;

            $scope.autocompleteEmployee = false;

            return false;
      }

      $scope.employeeSelectedInit = function (id)
          {

              if(id)
              {

                  UsersService.API('getUserById', {

                    'id' : id


                  }).then(function (employee) { 

                      $scope.addEmployee(employee);

                  });

              }

          }

      $scope.checkValuePreOrOld = function (pre , old , def)
      {
          if(!def)
            def = '';

          var value = def;

          if(pre)
            value = pre;

          if(old)
              value = old;

          return value;


      }


    }])

})();
