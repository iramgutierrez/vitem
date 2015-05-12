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

        /*Generar XLS */

        $scope.filename = 'reporte_proveedores';

        $scope.dataExport = false;

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
            field : 'rfc',
            label : 'RFC'
          },
          {
            field : 'business_name',
            label : 'Razón social'
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

        SuppliersService.all().then(function (data) {

          $scope.suppliersAll = data;

          $scope.suppliers = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.suppliers);  

          /*Generar XLS */      

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

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.suppliers);  

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
	        $scope.suppliers = $scope.suppliersAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('ShowController', ['$scope', '$filter' , 'ProductsService' , function ($scope ,  $filter , ProductsService ) {
        
        $scope.tab = 'profile';
        $scope.find = '';   
        $scope.status = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
        $scope.productsAll = false;

        $scope.init = function(supplier_id) 
        { 

          $scope.supplier_id = supplier_id;
          
          ProductsService.API(

            'findBySupplier',
            {       
              supplier_id : $scope.supplier_id,       
              page : $scope.page ,
              perPage : $scope.perPage , 
              find : $scope.find , 
              status : $scope.status

            }).then(function (data) {              

                $scope.productsP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                $scope.getBySupplier();

            });  

        }

        $scope.getBySupplier = function()
        {

          ProductsService.API(

            'getBySupplier',
            {
              supplier_id : $scope.supplier_id,     
            }

          ).then(function (data) {

            $scope.productsAll = data;

            $scope.products = data;

            $scope.search(true);

            $scope.paginate();

            //$scope.paginate(1);          

          });

        }

        

           

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

    .controller('FormController', [ '$scope' , function ($scope) {

      $scope.status = 'Inactivo';


    }])

})();
