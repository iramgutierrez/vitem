(function () {

  angular.module('sales.controllers', [])

    .controller('SalesController', ['$scope', '$filter' , 'SalesService' , function ($scope ,  $filter , SalesService ) {
        
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

        $scope.init = function() 
        { 
          
          SalesService.API(

            'find',
            {              
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

        $scope.init();

        SalesService.all().then(function (data) {

          $scope.salesAll = data;

          console.log(data);

          $scope.sales = data;

          $scope.search(true);

          $scope.paginate();     

        });

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

    .controller('FormController', [ '$scope', '$filter' , 'SalesService' , 'UsersService' , 'ClientsService' , 'ProductsService' , 'PackagesService' , 'DestinationsService' , function ($scope , $filter , SalesService,  UsersService , ClientsService , ProductsService , PackagesService , DestinationsService) {

      
      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

      UsersService.getByRoleId(1).then(function (data) {

          $scope.sellersAll = data;

      });

      $scope.find_client = '';

      $scope.autocompleteClient = false;

      $scope.clients = {};

      ClientsService.all().then(function (data) {

          $scope.clientsAll = data;

      });

      $scope.showAddProducts = true;

      $scope.showAddPacks = false;

      $scope.find_product = '';

      $scope.autocompleteProduct = false;

      $scope.products = {};

      $scope.productsSelected = [];

      ProductsService.all().then(function (data) {

          $scope.productsAll = data;

      });

      $scope.find_pack = '';

      $scope.autocompletePack = false;

      $scope.packs = {};

      $scope.packsSelected = [];

      PackagesService.all().then(function (data) {

          $scope.packsAll = data;

      });

      $scope.saleDate = $filter('date')((new Date).getTime());

      $scope.liquidationDate = $filter('date')((new Date).getTime());

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

      $scope.productsOld = [];

      $scope.packsOld = [];


        $scope.searchSeller = function ()
        {
          
            if($scope.find_seller.length != '')
            {
                $scope.sellers = UsersService.search($scope.find_seller , $scope.sellersAll , false , 1 , false , false , false , false );

                $scope.autocompleteSeller = true;

            }else{

                $scope.suppliers = {};

                $scope.autocompleteSeller = false;

            }
            

        }        

        $scope.addSeller = function(seller)
        { 

      
            $scope.employee_id = seller.employee.id;

            $scope.find_seller = seller.name;

            $scope.autocompleteSeller = false;

            return false;
        }

        $scope.searchClient = function ()
        {
          
            if($scope.find_client.length != '')
            {
                $scope.clients = ClientsService.search($scope.find_client , $scope.clientsAll , false , 1 , false , false );

                $scope.autocompleteClient = true;

            }else{

                $scope.clients = {};

                $scope.autocompleteClient = false;

            }
            

        }

        $scope.addClient = function(client)
        {

      
            $scope.client_id = client.id;

            $scope.find_client = client.name;

            $scope.autocompleteClient = false;

            return false;
        }

        $scope.searchProduct = function ()
        {
          
            if($scope.find_product.length != '')
            {
                $scope.products = ProductsService.search($scope.find_product , $scope.productsAll , 1 , $scope.productsSelected);               

                $scope.autocompleteProduct = true;

            }else{

                $scope.products = {};

                $scope.autocompleteProduct = false;

            }
            

        }

        $scope.addProduct = function(product)
        { 

            product.quantity = 1;

            $scope.productsSelected.push(product);

            $scope.find_product = '';

            $scope.autocompleteProduct = false;

            return false;
        }

        $scope.removeProduct = function (key)
        {

          $scope.productsSelected.splice(key, 1);

          $scope.find_product = '';

          $scope.autocompleteProduct = false;

        }

        $scope.searchPack = function ()
        { 
          
            if($scope.find_pack.length != '')
            {
                $scope.packs = PackagesService.search($scope.find_pack , $scope.packsAll , 1 , $scope.packsSelected);                

                $scope.autocompletePack = true;

            }else{

                $scope.packs = {};

                $scope.autocompletePack = false;

            }
            

        }

        $scope.addPack = function(pack)
        { 

            pack.quantity = 1;

            $scope.packsSelected.push(pack);

            $scope.find_pack = '';

            $scope.autocompletePack = false;

            return false;
        }

        $scope.removePack = function (key)
        {

          $scope.packsSelected.splice(key, 1);

          $scope.find_pack = '';

          $scope.autocompletePack = false;

        }

        $scope.addQuantity = function (quantity , stock)
        {

          quantity = (isNaN(parseInt(quantity))) ? 0 : parseInt(quantity);

          stock = (isNaN(parseInt(stock))) ? false : parseInt(stock);

          if(stock)
          {
            if( (quantity + 1) <= stock)
            {

              return quantity + 1;

            }
            else
            {

              return quantity;

            }

          }

          return quantity + 1;          

        }

        $scope.removeQuantity = function (quantity)
        {

          quantity = (isNaN(parseInt(quantity))) ? 0 : parseInt(quantity);

          if(quantity > 1)
          {
            
            return quantity - 1;

          }
          else
          {

            return quantity;

          }

        }

        $scope.pricePerQuantity = function( price , quantity)
        {

          price = (isNaN(parseFloat(price))) ? 0 : parseFloat(price);

          quantity = (isNaN(parseFloat(quantity))) ? 1 : parseFloat(quantity);

          return price * quantity;

        }

        $scope.getTotalPrice = function()
        {

          var price = 0;

          angular.forEach($scope.productsSelected, function(value, key) {

              price += $scope.pricePerQuantity(value.price , value.quantity);
            

          });

          angular.forEach($scope.packsSelected, function(value, key) {

              price += $scope.pricePerQuantity(value.price , value.quantity);
            

          });

          return price;

        }

        $scope.hideItems = function () 
        {
            window.setTimeout(function() {

                $scope.$apply(function() {
                
                    $scope.autocompleteSeller = false;
                
                    $scope.autocompleteClient = false;

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

        $scope.addItems = function (item)
        {

          if(item == 'product')
          {

            $scope.showAddProducts = true;
            $scope.showAddPacks = false;

          }
          else
          {

            $scope.showAddProducts = false;
            $scope.showAddPacks = true;

          }

        }

        $scope.getProductsSelected = function (sale_id)
        {

          SalesService.getProducts(sale_id).then(function (data) {

            $scope.productsSelected = data;

          });

        }

        $scope.getPacksSelected = function (sale_id)
        {

          SalesService.getPacks(sale_id).then(function (data) {

            $scope.packsSelected = data;

          });

        }

        $scope.getAllSelected = function(sale_id)
        {

          $scope.getProductsSelected(sale_id);

          $scope.getPacksSelected(sale_id);

        }

        $scope.quantityInit = function (item)
        {

          quantity = item.quantity;

          if(item.hasOwnProperty('pivot'))
          {
            
            if(item.pivot.hasOwnProperty('quantity'))
            
            {

              quantity = item.pivot.quantity;

            }

          }

          return quantity; 

        }

        $scope.getProductsOld = function()
        {

          angular.forEach($scope.productsOld, function(value, key) {
            
              ProductsService.findById(value.product_id).then(function (data) {

                data.quantity = value.quantity;

                $scope.productsSelected.push(data);

              });

          });

        }

        $scope.getPacksOld = function()
        {

          angular.forEach($scope.packsOld, function(value, key) {
            
              PackagesService.findById(value.pack_id).then(function (data) {

                data.quantity = value.quantity;

                $scope.packsSelected.push(data);

              });

          });

        }

        $scope.delivery_tab = 1;

        $scope.deliverExists = false;

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

    }]) 

    .controller('ShowController', [ '$scope'  , function ($scope ) {



    }]);

})();