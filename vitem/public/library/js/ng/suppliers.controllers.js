(function () {

  angular.module('suppliers.controllers', [])

    .controller('SuppliersController', ['$scope', '$filter' , 'SuppliersService', function ($scope ,  $filter , SuppliersService) {
        
        $scope.find = '';   
        $scope.type = ''; 
        $scope.status = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        SuppliersService.all().then(function (data) {

          $scope.suppliersAll = data;

          $scope.suppliers = data;

          $scope.paginate(1);

          

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.suppliers.length / $scope.perPage );

            $scope.suppliersP = $scope.suppliers.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.suppliersP = $scope.suppliers
          }
        }



        $scope.search = function ()
        {
          
        	$scope.suppliers = SuppliersService.search($scope.find , $scope.suppliersAll , $scope.status );

          $scope.paginate(1);

        }

        $scope.clear = function () 
        {
        	$scope.find = '';   
	        $scope.type = ''; 
          $scope.status = ''; 
	        $scope.sort = 'id';
	        $scope.reverse = false;
	        $scope.suppliers = $scope.suppliersAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , function ($scope) {

      $scope.status = 'Inactivo';


    }])

})();
