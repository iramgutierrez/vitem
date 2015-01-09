(function () {

  angular.module('products.controllers', [])

    .controller('ProductsController', ['$scope', '$filter' , 'ProductsService' , function ($scope ,  $filter , ProductsService ) {
        
        $scope.find = '';   
        $scope.status = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 50;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
        $scope.productsAll = false;

        $scope.init = function() 
        { 
          
          ProductsService.API(

            'find',
            {              
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              status : $scope.status

            }).then(function (data) {              

                $scope.productsP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });  

        }

        $scope.init();



        ProductsService.all().then(function (data) {

          $scope.productsAll = data;

          $scope.products = data;

          $scope.search(true);

          $scope.paginate();

          //$scope.paginate(1);          

        });

           

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p); 

            if(!$scope.productsAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.products.length;        

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.productsP = $scope.products.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.productsP = $scope.products
          }
        }



        $scope.search = function ( init )
        {
          
          if(!$scope.productsAll)
          {
          
            $scope.init();

          }
          else
          {

            $scope.products = ProductsService.search($scope.find , $scope.productsAll , $scope.status );

          }

          if(!init){

            $scope.paginate(1);

          }

        }

        $scope.clear = function () 
        {
          $scope.find = '';   
          $scope.type = ''; 
          $scope.status = ''; 
          $scope.sort = 'id';
          $scope.reverse = false;
          $scope.products = $scope.productsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'SuppliersService'  , function ($scope , SuppliersService  ) {

      $scope.status = 'No disponible';
      $scope.find = '';
      $scope.autocomplete = false;
      $scope.supplierSelected = {};

        SuppliersService.all().then(function (data) {

          $scope.countriesAll = data;

        });
        $scope.search = function ()
        {
          
            if($scope.find.length != '')
            {
                $scope.suppliers = SuppliersService.search($scope.find , $scope.countriesAll , 1 );

                $scope.autocomplete = true;

            }else{

                $scope.suppliers = {};

                $scope.autocomplete = false;

            }
            

        }

        $scope.addAutocomplete = function(supplier)
        {

      
            $scope.find = supplier.name;

            $scope.supplierSelected = supplier;

            $scope.autocomplete = false;

            return false;
        }

        $scope.hideItems = function () 
        {
            window.setTimeout(function() {

                $scope.$apply(function() {
                
                    $scope.autocomplete = false;

                });

            }, 300);
            
        }

        $scope.supplierSelectedInit = function (id)
        {
          
          SuppliersService.findById(id).then(function (data) {

            $scope.supplierSelected = data;
                
            $scope.newSupplier = false;
                
            $scope.find = $scope.supplierSelected.name ;

          });

          

        }    

    }]);

})();