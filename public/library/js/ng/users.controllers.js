(function () {

  angular.module('users.controllers', [])

    .controller('UsersController', ['$scope', '$filter' , 'UsersService', function ($scope ,  $filter , UsersService) {
        
        $scope.find = '';   
        $scope.type = ''; 
        $scope.status = ''; 
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.operatorEntryDate = '';
        $scope.entryDate = '';
        $scope.operatorSalary = '';
        $scope.salary = '';
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
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

        /*Generar XLS */

        $scope.filename = 'reporte_usuarios';

        $scope.headersExport = JSON.stringify([
          {
            field : 'id',
            label : 'Id'
          },
          {
            field : 'name',
            label : 'Nombre'
          },
          {
            field : 'username',
            label : 'Nombre de usuario'
          },
          {
            field : {
              role : 'name'
            },
            label : 'Tipo de usuario'
          },
          {
            field : {
              store : 'name'
            },
            label : 'Sucursal'
          },
          {
            field : {
              employee : 'salary'
            },
            label : 'Salario'
          },
          {
            field : {
              employee : 'entry_date'
            },
            label : 'Fecha de ingreso'
          },
          {
            field : 'email',
            label : 'Correo electrónico'
          },
          {
            field : 'phone',
            label : 'Teléfono'
          },
          {
            field : 'address',
            label : 'Dirección'
          },
          {
            field : 'street',
            label : 'Calle'
          },
          {
            field : 'outer_number',
            label : 'Número exterior'
          },
          {
            field : 'inner_number',
            label : 'Número interior'
          },
          {
            field : 'zip_code',
            label : 'Código postal'
          },
          {
            field : 'colony',
            label : 'Colonia'
          },
          {
            field : 'city',
            label : 'Ciudad'
          },
          {
            field : 'state',
            label : 'Estado'
          },
        ]);        

        $scope.generateJSONDataExport = function( data )
        { 

          return JSON.stringify(data);

        }

        /*Generar XLS */

        UsersService.all().then(function (data) {

          $scope.usersAll = data;

          $scope.users = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.users);  

          /*Generar XLS */       

          $scope.paginate(1);          

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.users.length / $scope.perPage );

            $scope.usersP = $scope.users.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.usersP = $scope.users
          }
        }



        $scope.search = function ()
        {     

        	$scope.salary = $filter('decimal')($scope.salary);

        	$scope.users = UsersService.search($scope.find , $scope.usersAll , $scope.type , $scope.status , $scope.operatorEntryDate , $scope.entryDate , $scope.operatorSalary , $scope.salary );

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.users);  

          /*Generar XLS */      

          $scope.paginate(1);

        }

        $scope.clear = function () 
        {
        	$scope.find = '';   
	        $scope.type = '';  
          $scope.status = '';  
	        $scope.sort = 'id';
	        $scope.reverse = false;
	        $scope.operatorSalary = '';
	        $scope.salary = '';
          $scope.operatorEntryDate = '';
          $scope.entryDate = '';
	        $scope.users = $scope.usersAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'UsersService' , function ($scope , UsersService) {

      $scope.status = 'Inactivo';      
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

    }])

    .controller('ShowController', [ '$scope' , 'UsersService' , 'SalesService' , function ($scope , UsersService , SalesService ) {

        $scope.tab = 'perfil';
        $scope.find = '';   
        $scope.sale_type = '';  
        $scope.pay_type = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
        $scope.operatorSaleDate = '';
        $scope.saleDate = '';
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

        $scope.init = function(employee_id) 
        { 

          $scope.employee_id = employee_id;
          
          SalesService.API(

            'findBySeller',
            {     
              employee_id : employee_id ,         
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              sale_type : $scope.sale_type , 
              pay_type : $scope.pay_type, 
              operatorSaleDate : $scope.operatorSaleDate , 
              saleDate : $scope.saleDate

            }).then(function (data) {      

                $scope.salesP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });


        }

        $scope.getBySeller = function()
        {

          SalesService.API(

            'getBySeller',

            {
              employee_id : $scope.employee_id
            }

          ).then(function (data) {

            $scope.salesAll = data;

            $scope.sales = data;

            $scope.search(true);

            $scope.paginate();     

          });
        }

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);   

            if(!$scope.salesAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.sales.length;          

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.salesP = $scope.sales.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.salesP = $scope.sales
          }
        }



        $scope.search = function ( init )
        { 
          
          if(!$scope.salesAll)
          { 
          
            $scope.init();

          }
          else
          {
          
            $scope.sales = SalesService.search($scope.find , $scope.salesAll , $scope.sale_type , $scope.pay_type, $scope.operatorSaleDate , $scope.saleDate);

            
          }

          if(!init){

            $scope.paginate(1);

          }

        }

        $scope.clear = function () 
        {
          $scope.find = '';   
          $scope.sale_type = '';
          $scope.pay_type = '';
          $scope.operatorSaleDate = '';
            $scope.saleDate = '';
          $scope.sort = 'id';
          $scope.reverse = false;
          $scope.sales = $scope.salesAll;
          $scope.paginate(1);
          $scope.modal = false;

        }

    }])

})();
