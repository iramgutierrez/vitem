(function () {

  angular.module('clients.controllers', [])

    .controller('ClientsController', ['$scope', '$filter' , 'ClientsService', function ($scope ,  $filter , ClientsService) {
        $scope.tab = 'profile';
        $scope.find = '';   
        $scope.type = ''; 
        $scope.status = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.operatorEntryDate = '';
        $scope.entryDate = '';
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

        $scope.filename = 'reporte_clientes';

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
            field : 'client_type_id',
            label : 'Tipo de cliente'
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
            field : 'entry_date',
            label : 'Cliente desde'
          },
          {
            field : 'rfc',
            label : 'RFC'
          },
          {
            field : 'business_name',
            label : 'Razón social'
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

        ClientsService.all().then(function (data) {

          $scope.clientsAll = data;

          $scope.clients = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.clients);  

          /*Generar XLS */       

          $scope.paginate(1);

          

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.clients.length / $scope.perPage );

            $scope.clientsP = $scope.clients.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.clientsP = $scope.clients
          }
        }



        $scope.search = function ()
        {
          
        	$scope.clients = ClientsService.search($scope.find , $scope.clientsAll , $scope.type , $scope.status , $scope.operatorEntryDate , $scope.entryDate );

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.clients);  

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
          $scope.operatorEntryDate = '';
          $scope.entryDate = '';
	        $scope.clients = $scope.clientsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('ShowController', ['$scope', '$filter' , 'SalesService', function ($scope ,  $filter , SalesService) {

        $scope.tab = 'profile';
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

        $scope.init = function(client_id) 
        { 

          $scope.client_id = client_id;
          
          SalesService.API(

            'findByClient',
            {     
              client_id : client_id ,         
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

        $scope.getByClient = function()
        {

          SalesService.API(

            'getByClient',

            {
              client_id : $scope.client_id
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

    .controller('FormController', [ '$scope' , function ($scope) {

      $scope.status = 'Inactivo';
      $scope.entryDate = 'd';
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

})();
