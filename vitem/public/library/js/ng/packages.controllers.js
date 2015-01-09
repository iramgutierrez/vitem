(function () {

  angular.module('packages.controllers', [])

    .controller('PacksController', ['$scope', '$filter' , 'PackagesService' , function ($scope ,  $filter , PackagesService ) {
        
        $scope.find = '';   
        $scope.status = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        PackagesService.all().then(function (data) {

          $scope.packsAll = data;

          console.log($scope.productsAll);


          $scope.packs = data;

          $scope.paginate(1);

          

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.packs.length / $scope.perPage );

            $scope.packsP = $scope.packs.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.productsP = $scope.packs
          }
        }



        $scope.search = function ()
        {
          
        	$scope.packs = PackagesService.search($scope.find , $scope.packsAll , $scope.status );

          $scope.paginate(1);

        }

        $scope.clear = function () 
        {
        	$scope.find = '';   
	        $scope.type = ''; 
          $scope.status = ''; 
	        $scope.sort = 'id';
	        $scope.reverse = false;
	        $scope.packs = $scope.packsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'ProductsService', 'PackagesService'  , function ($scope  ,  ProductsService , PackagesService ) {

      $scope.status = 'No disponible';
      $scope.find = '';
      $scope.autocomplete = false;
      $scope.productSelected = {};
      $scope.productsSelected = [];
      $scope.products = [];
      $scope.productsInit = [];
      $scope.currentProduct = 0;
      $scope.price = 0;
      $scope.cost = 0;
      $scope.production_days = 0;
      $scope.productsAll = []

      ProductsService.all().then(function (data) {

          
        $scope.productsAll = data;

      });

      $scope.productsOld = [];

      $scope.showProduct = function(productId)
      {
          

          angular.forEach($scope.products, function(value, key) {

            if(key == productId)
            {
              $scope.products[key].show = !$scope.products[key].show
            }
            else
            {
              $scope.products[key].show = false;
            }

          });
        }

        $scope.addProduct = function(product)
        { 

            product.quantity = 1;

            $scope.productsSelected.push(product);

            $scope.find = '';

            $scope.autocomplete = false;

            return false;
        }

        $scope.removeProduct = function (key)
        {

          $scope.productsSelected.splice(key, 1);

          $scope.find = '';

          $scope.autocomplete = false;

        }

        /*$scope.updateFields = function(){

          $scope.price = 0;

          $scope.cost = 0;

          $scope.production_days = 0;

          angular.forEach($scope.products, function(value, key) {

            if(value.exists && value.productSelected)
            {

              $scope.price += ( isNaN( parseFloat( value.productSelected.price ) ) ) ? 0 : parseFloat( value.productSelected.price );

              $scope.cost += ( isNaN( parseFloat( value.productSelected.cost ) ) ) ? 0 : parseFloat( value.productSelected.cost );

              $scope.production_days = ( parseFloat( value.productSelected.production_days ) > $scope.production_days ) ?  parseFloat( value.productSelected.production_days ) : $scope.production_days;
              
            }

          });


        }*/

        $scope.search = function ()
        {             

            if($scope.find.length != '')
            { 
                $scope.products = ProductsService.search($scope.find , $scope.productsAll , 1, $scope.productsSelected);

                $scope.autocomplete = true;

            }else{

                $scope.products = {};

                $scope.autocomplete = false;

            }      

        }

        $scope.addAutocomplete = function(product , productId)
        {

            
            $scope.products[productId].find = product.name;

            $scope.products[productId].status = product.status;

            $scope.products[productId].productSelected = product;

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

        $scope.productSelectedInit = function (id , quantity , productId)
        {
         

          ProductsService.findById(id).then(function (data) {

            
              $scope.products.push({
                show: false,
                exists : true,
                number : $scope.products.length ,
                find : data.name,
                quantity : quantity,
                status : data.status,
                productSelected: data

              });

              $scope.regenerateIndexes();

              //$scope.updateFields();

          });          

        }    
        $scope.productsSelectedInit = function ()
        {         

          angular.forEach($scope.productsInit, function(value, key) {

            $scope.productSelectedInit(value.product_id , value.quantity ,  value.k);

          });

          $scope.products = $scope.productsInit;
        }

        $scope.regenerateIndexes = function ()
        {
          
          number = 0;

          angular.forEach($scope.products, function(value, key) {

            if(value.exists)
            {
              $scope.products[key].number = number;

              number++;
            }

          });
        }

        $scope.completeProducts = function ()
        {

          var showFirst = true;

          for(p = $scope.products.length; p < 2; p ++)
          {
            $scope.products.push({
                show: showFirst,
                exists : true,
                number : $scope.products.length ,
                find : '',
                quantity : 1,
                status : 1,
                productSelected: false

              });

            if(showFirst)
              showFirst = false;
          }

          $scope.regenerateIndexes();

        }

        $scope.getProducts = function(packId)
        {
          
          PackagesService.getProducts(packId).then(function (data) {

              var showFirst = true;

              angular.forEach(data, function(value, key) {
                  console.log(value);
                
                  $scope.products.push({
                    show: showFirst,
                    exists : true,
                    number : $scope.products.length ,
                    find : value.name,
                    quantity : value.pivot.quantity,
                    status : value.status,
                    productSelected: value

                  });

                  if(showFirst)
                    showFirst = false;

              });              
              
              $scope.completeProducts();

          }); 

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

          return price;

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

        $scope.getProductsSelected = function (pack_id)
        {

          PackagesService.getProducts(pack_id).then(function (data) {

            $scope.productsSelected = data;

          });

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

    }])   

    .controller('ShowController', [ '$scope' , 'PackagesService'  , function ($scope , PackagesService  ) {



    }]);

})();