(function () {

  angular.module('deliveries.controllers', [])    

    .controller('FormController', [ '$scope' , '$filter','SalesService' , 'UsersService' , 'DestinationsService' , function ($scope , $filter, SalesService , UsersService , DestinationsService) {

      $scope.sale_id = false;

      $scope.sheet = '';

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

            if(!sale.delivery)
            {

              $scope.sale = sale; 

              $scope.sale_id = sale.id;

              $scope.deliveryExists = false;

            }
            else
            {

              $scope.deliveryExists = 'Esta venta ya tiene una entrega asignada.';


            }

        });

      }


      $scope.getSale = function()
      { 

        SalesService.API('findById' , {id : $scope.sale_id}).then(function (sale) {

            $scope.sale = sale;

            $scope.sale_id = sale.id;

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

    }]) 

    .controller('EditController', [ '$scope' , '$filter' , '$q' ,'SalesService' , 'UsersService' , 'DeliveriesService' , 'DestinationsService' , function ($scope , $filter , $q ,SalesService , UsersService , DeliveriesService , DestinationsService) {




      $scope.init = function(id)
      {

        DeliveriesService.API('findById' , {id : id}).then(function (delivery) {

          console.log(delivery);

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

    }]) 

    .controller('ShowController', [ '$scope'  , function ($scope ) {



    }]);


})();