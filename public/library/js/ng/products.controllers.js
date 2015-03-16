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

        $scope.cost = '';

        $scope.percent_gain = ''; 

        $scope.suggested_price = ''

        $scope.calculatePrice = function()
        {


          if($scope.cost && $scope.percent_gain)
          {

            $scope.suggested_price = parseFloat( ($scope.cost*$scope.percent_gain)/100 ) + parseFloat($scope.cost);

          }

          $scope.assignSuggestedPrice();
          
        }

        $scope.assignSuggestedPrice = function()
        {

          if($scope.suggested_price_active && $scope.suggested_price)
          {

            $scope.price = $scope.suggested_price;

          }

        }

        $scope.calculateTotalStock = function()
        {

          var stock = $scope.stock;

          var total_stock = 0;

          angular.forEach($scope.stores, function(store, key) {

            total_stock += parseInt(store.quantity);

          });

          $scope.total_stock = total_stock;

          console.log($scope.total_stock);


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

        $scope.init = function(product_id) 
        { 

          $scope.product_id = product_id;
          
          SalesService.API(

            'findByProduct',
            {     
              product_id : product_id ,         
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

        $scope.getByProduct = function()
        {

          SalesService.API(

            'getByProduct',

            {
              product_id : $scope.product_id
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
        { console.log($scope.find);
          
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