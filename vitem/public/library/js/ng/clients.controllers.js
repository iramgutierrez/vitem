(function () {

  angular.module('clients.controllers', [])

    .controller('ClientsController', ['$scope', '$filter' , 'ClientsService', function ($scope ,  $filter , ClientsService) {
        
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

        ClientsService.all().then(function (data) {

          $scope.clientsAll = data;

          $scope.clients = data;

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
