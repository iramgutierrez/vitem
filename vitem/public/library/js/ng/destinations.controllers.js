(function () {

  angular.module('destinations.controllers', [])

    .controller('DestinationsController', ['$scope', '$filter' , 'DestinationsService' , function ($scope ,  $filter , DestinationsService ) {
        
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
          
          DestinationsService.API(

            'find',
            {              
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              type : $scope.type , 

            }).then(function (data) {              

                $scope.destinationsP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });  

        }

        $scope.init();

        DestinationsService.all().then(function (data) {

          $scope.destinationsAll = data;

          $scope.destinations = data;

          $scope.search(true);

          $scope.paginate();     

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);   

            if(!$scope.destinationsAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.destinations.length;          

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.destinationsP = $scope.destinations.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.destinationsP = $scope.destinations
          }
        }



        $scope.search = function ( init )
        { 

          if(!$scope.destinationsAll)
          {
          
            $scope.init();

          }
          else
          {
          
            $scope.destinations = DestinationsService.search($scope.find , $scope.destinationsAll , $scope.type );

            
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
          $scope.destinations = $scope.destinationsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , function ($scope) {

      $scope.change_type = function()
      {

        console.log($scope.type);

      }


    }])

})();
