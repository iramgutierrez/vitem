(function () {

    angular.module('stores.controllers', [])

        .controller('StoresController', ['$scope', '$filter' , 'StoresService' , function ($scope ,  $filter , StoresService ) {
            
            $scope.find = '';   
            $scope.sort = 'id';
            $scope.reverse = false;
            $scope.pagination = true;
            $scope.page = 1;
            $scope.perPage = 10;
            $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];

            $scope.init = function() 
            { 
              
              StoresService.API(

                'find',
                {              
                  page : $scope.page ,
                  perPage : $scope.perPage , 
                  find : $scope.find 

                }).then(function (data) {          

                    $scope.storesP = data.data;

                    $scope.total = data.total;

                    $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                });  

            }

            $scope.init();

            StoresService.all().then(function (data) {

              $scope.storesAll = data;

              $scope.stores = data;

              $scope.search(true);

              $scope.paginate();     

            });

            $scope.paginate = function( p )
            {
              if($scope.pagination)
              {            

                if(p)
                  $scope.page = parseInt(p);   

                if(!$scope.storesAll)
                {
                
                  $scope.init();

                }
                else
                {

                  $scope.total = $scope.stores.length;          

                  $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                  $scope.storesP = $scope.stores.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

                }

              }
              else
              {
                $scope.storesP = $scope.stores
              }
            }



            $scope.search = function ( init )
            { 

              if(!$scope.storesAll)
              {
              
                $scope.init();

              }
              else
              { 
                
                $scope.stores = StoresService.search($scope.find , $scope.storesAll );

                
              }

              if(!init){

                $scope.paginate(1);

              }

            }

            $scope.clear = function () 
            {
                $scope.find = '';   
                $scope.sort = 'id';
                $scope.reverse = false;
                $scope.stores = $scope.storesAll;
                $scope.paginate(1);
                $scope.modal = false;

            }


        }])

       .controller('FormController', [ '$rootScope' , '$scope', '$filter' ,  'StoresService' , function ($rootScope , $scope , $filter , OrdersService) {


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