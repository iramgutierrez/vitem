(function () {

  angular.module('deliveries.controllers', []) 

    .controller('DeliveriesController', ['$scope', '$filter' , 'DeliveriesService' , function ($scope ,  $filter , DeliveriesService ) {
        
        $scope.find = '';   
        $scope.type = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        $scope.init = function() 
        { 
          
          DeliveriesService.API(

            'find',
            {              
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              type : $scope.type , 

            }).then(function (data) {      

              console.log(data);        

                $scope.deliveriesP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });  

        }

        $scope.init();

        DeliveriesService.all().then(function (data) {

          $scope.deliveriesAll = data;

          $scope.deliveries = data;

          $scope.search(true);

          $scope.paginate();     

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);   

            if(!$scope.deliveriesAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.deliveries.length;          

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.deliveriesP = $scope.deliveries.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.deliveriesP = $scope.deliveries
          }
        }



        $scope.search = function ( init )
        { 

          if(!$scope.deliveriesAll)
          {
          
            $scope.init();

          }
          else
          {
          
            $scope.deliveries = DeliveriesService.search($scope.find , $scope.deliveriesAll );

            
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
          $scope.deliveries = $scope.deliveriesAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])   

    .controller('FormController', [ '$scope' , '$filter','SalesService' , 'UsersService' , 'DestinationsService' , function ($scope , $filter, SalesService , UsersService , DestinationsService) {

      $scope.sale_id = false;

      $scope.sheet = '';

      $scope.pay_types = {};

      SalesService

        .API('getPayTypes')

        .then(function (pay_types) {

            $scope.pay_types = pay_types;

        });

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

      $scope.deliverExists = false;

      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id; 

        if(sale_id)
          $scope.getSale();

      }

      $scope.setSaleSheet = function(sheet)
      { 

        if(sheet != '')
        {

          $scope.sheet = sheet; 

          $scope.searchSaleBySheet();

        }

      }

      $scope.searchSaleBySheet = function()
      {

        SalesService.API('findBySheet' , {sheet : $scope.sheet}).then(function (sale) {

          if(!sale.hasOwnProperty('id'))
            {

              $scope.error = 'No se encontro la venta especificada';

              $scope.sale_id = false;

              $scope.sale = false;

            }
            else
            {

              if(!sale.delivery)
              {

                 $scope.error = false;

                $scope.sale = sale; 

                $scope.sale_id = sale.id;

                $scope.deliveryExists = false;

              }
              else
              {

                $scope.deliveryExists = 'Esta venta ya tiene una entrega asignada.';

                $scope.sale_id = false;

                $scope.sale = false;


              }

            }

        });

      }


      $scope.getSale = function()
      { 

        SalesService.API('findById' , {id : $scope.sale_id}).then(function (sale) { console.log(sale);

            if(!sale.hasOwnProperty('id'))
            {

              $scope.error = 'No se encontro la venta especificada';

              $scope.sale_id = false;

              $scope.sale = false;

            }
            else
            {

              if(!sale.delivery)
              {

                 $scope.error = false;

                $scope.sale = sale; 

                $scope.sale_id = sale.id;

                $scope.deliveryExists = false;

              }
              else
              {

                $scope.deliveryExists = 'Esta venta ya tiene una entrega asignada.';

                $scope.sale_id = false;

                $scope.sale = false;


              }

            }

        });

      }
      
      $scope.find_driver = '';

      $scope.autocompleteDriver = false;

      $scope.drivers = {};

      UsersService.getByRoleId(6).then(function (data) {

            $scope.driversAll = data;

      });

      $scope.searchDriver = function ()
      {           
            if($scope.find_driver.length != '')
            {
                $scope.drivers = UsersService.search($scope.find_driver , $scope.driversAll , false , 1 , false , false , false , false );

                $scope.autocompleteDriver = true;

            }else{

                $scope.drivers = {};

                $scope.autocompleteDriver = false;

            }
            

      }        

      $scope.addDriver = function(driver)
      { 

      
            $scope.employee_id = driver.employee.id;

            $scope.find_driver = driver.name;

            $scope.autocompleteDriver = false;

            return false;
      }

      $scope.find_destination = '';

      $scope.destination = false;

      $scope.autocompleteDestination = false;

      $scope.destinations = {};

      DestinationsService.all().then(function (data) {

            $scope.destinationsAll = data;

      });

      $scope.searchDestination = function ()
      {           
            if($scope.find_destination.length != '')
            {
                $scope.destinations = DestinationsService.search($scope.find_destination , $scope.destinationsAll );

                $scope.autocompleteDestination = true;

            }else{

                $scope.destinations = {};

                $scope.destination = false;

                $scope.autocompleteDestination = false;

            }
            

      }        

      $scope.addDestination = function(destination)
      { 
            $scope.destination = destination;
      
            $scope.destination_id = destination.id;

            $scope.find_destination = $filter('destination_types')(destination.type) + ': ' + destination.value_type;

            $scope.autocompleteDestination = false;

            return false;
      }

      $scope.checkNewDestination = function()
      {

        if($scope.newDestination === 1)
        {

          

        }
        else
        {



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

          console.log(value);

          return value;


      }

    }]) 

    .controller('EditController', [ '$scope' , '$filter' , '$q' ,'SalesService' , 'UsersService' , 'DeliveriesService' , 'DestinationsService' , function ($scope , $filter , $q ,SalesService , UsersService , DeliveriesService , DestinationsService) {

      $scope.pay_types = {};

      SalesService
          .API('getPayTypes')
          .then(function (pay_types) {

              $scope.pay_types = pay_types;

          })


      $scope.init = function(id)
      {

        DeliveriesService.API('findById' , {id : id}).then(function (delivery) {

          $scope.delivery = delivery;

          $scope.sale = delivery.sale;   

          $scope.sale_id = delivery.sale.id;     

          $scope.employee_id = $scope.delivery.employee_id; 

          $scope.find_driver = $scope.delivery.employee.user.name;   

          $scope.destination_id = $scope.delivery.destination_id; 

          $scope.find_destination = $filter('destination_types')($scope.delivery.destination.type) + ': ' + $scope.delivery.destination.value_type; 

          $scope.destination = $scope.delivery.destination;

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
              dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

          };

        })

      }


      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id; 

        $scope.getSale();

      }

      $scope.getSale = function()
      { 

        SalesService.API('findById' , {id : $scope.sale_id}).then(function (sale) {

            $scope.sale = sale;

            angular.forEach($scope.sale.sale_payments, function(value, key) {


              $scope.sale.sale_payments[key].in_commission = true;

            });

        }).then(function(){

          $scope.commission_type = $scope.getCommissionTypeInit();

        }).then(function(){

          $scope.getTotalCommission();

          $scope.percent = 0;

          $scope.getTotal();

        });

      }  

      $scope.find_driver = '';

      $scope.autocompleteDriver = false;

      $scope.drivers = {};

      UsersService.getByRoleId(6).then(function (data) {

            $scope.driversAll = data;

      });

      $scope.searchDriver = function ()
      {           
            if($scope.find_driver.length != '')
            {
                $scope.drivers = UsersService.search($scope.find_driver , $scope.driversAll , false , 1 , false , false , false , false );

                $scope.autocompleteDriver = true;

            }else{

                $scope.drivers = {};

                $scope.autocompleteDriver = false;

            }
            

      }        

      $scope.addDriver = function(driver)
      { 

      
            $scope.employee_id = driver.employee.id;

            $scope.find_driver = driver.name;

            $scope.autocompleteDriver = false;

            return false;
      }

      $scope.find_destination = '';

      $scope.destination = false;

      $scope.autocompleteDestination = false;

      $scope.destinations = {};

      DestinationsService.all().then(function (data) {

            $scope.destinationsAll = data;

      });

      $scope.searchDestination = function ()
      {           
            if($scope.find_destination.length != '')
            {
                $scope.destinations = DestinationsService.search($scope.find_destination , $scope.destinationsAll );

                $scope.autocompleteDestination = true;

            }else{

                $scope.destinations = {};

                $scope.destination = false;

                $scope.autocompleteDestination = false;

            }
            

      }        

      $scope.addDestination = function(destination)
      { 
            $scope.destination = destination;
      
            $scope.destination_id = destination.id;

            $scope.find_destination = $filter('destination_types')(destination.type) + ': ' + destination.value_type;

            $scope.autocompleteDestination = false;

            return false;
      }

      $scope.checkNewDestination = function()
      {

        if($scope.newDestination === 1)
        {

          

        }
        else
        {



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

    .controller('ShowController', [ '$scope'  , function ($scope ) {



    }]);


})();