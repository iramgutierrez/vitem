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

    .controller('FormController', [ '$rootScope' ,'$scope' , 'ProductsService', 'PackagesService'  , function ($rootScope , $scope  ,  ProductsService , PackagesService ) {

      $scope.status = 'No disponible';
      $scope.find = '';
      $scope.autocomplete = false;
      $scope.productSelected = {};
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

            $rootScope.productsSelected.push(product);

            $scope.find = '';

            $scope.autocomplete = false;

            return false;
        }

        $scope.removeProduct = function (key)
        {

          $rootScope.productsSelected.splice(key, 1);

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
                $scope.products = ProductsService.search($scope.find , $scope.productsAll , 1, $rootScope.productsSelected);

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
        $rootScope.productsSelectedInit = function ()
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

          angular.forEach($rootScope.productsSelected, function(value, key) {

              price += $scope.pricePerQuantity(value.price , value.quantity);
            

          });

          return price;

        }

        $scope.getProductsOld = function()
        {

          angular.forEach($scope.productsOld, function(value, key) {
            
              ProductsService.findById(value.product_id).then(function (data) {

                data.quantity = value.quantity;

                $rootScope.productsSelected.push(data);

              });

          });

        }

        $scope.getProductsSelected = function (pack_id)
        {

          PackagesService.getProducts(pack_id).then(function (data) {

            $rootScope.productsSelected = data;

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



      $scope.checkValuePreOrOld = function (pre , old , def)
      {
          if(!def)
            def = '';

          var value = def;

          if(pre)
            value = pre;

          if(old)
              value = old;

          console.log(value);

          return value;


      }

    }])

    .controller('AddProductController', ['$rootScope' , '$scope' , 'SuppliersService'  , function ($rootScope , $scope , SuppliersService  ) {

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

          $scope.suggested_price = '';

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

          $scope.errorres = [];


          $scope.initJQuery = function(url_dropzone)
          {

              $("#imageProduct").dropzone(
                  {
                      url:  url_dropzone,
                      previewTemplate : "",
                      paramName : "image",
                      success : function(file , data) {

                          console.log(data);

                          if(data.hasOwnProperty('success') && data.success)
                          {

                              $("#addproductForm").find(".image").html("<img style=\"width:250px;\" src=\""+data.path+'/'+data.filename+"\" />");

                              $("input.imageProductInput").val(data.filename);

                          }

                      }
                  }

              );

              var validate = $("#addproductForm").validate({

                  rules : {

                      name : {
                          required : true,
                          minlength : 4,
                          maxlength : 40
                      },
                      key : {
                          required : true,
                          remote:
                          {
                              url: 'API/products/checkKey',
                              type: "get",
                              data:
                              {
                              },
                          }
                      },
                      model : {
                          required : true
                      },
                      description : {
                          required : true
                      },
                      stock : {
                          required : true,
                          number : true
                      },
                      price : {
                          required : true,
                          number : true
                      },
                      cost : {
                          required : true,
                          number : true
                      },
                      production_days : {
                          required : true,
                          number : true
                      },
                      user_id : {
                          required : true
                      },
                      supplier_id : {
                          required : true
                      },
                      'supplier[name]' : {
                          required : true,
                          minlength : 4,
                          maxlength : 40
                      },
                      'supplier[email]' : {
                          required : true,
                          email : true,
                          remote:
                          {
                              url: 'API/suppliers/checkEmail',
                              type: "get",
                              data:
                              {
                              },
                          }
                      },
                      'supplier[street]' : {
                          required : true
                      },
                      'supplier[outer_number]' : {
                          required : true
                      },
                      'supplier[zip_code]' : {
                          required : true
                      },
                      'supplier[phone]' : {
                          required : true
                      }
                  },
                  messages : {

                      key : {

                          remote : "El código especificado ya esta en uso."

                      },
                      'supplier[email]' : {

                          remote : "El correo electrónico especificado ya esta en uso."

                      }
                  },
                  submitHandler : function(form)
                  {

                      $.post($("#addproductForm").attr('action') , $("#addproductForm").serialize() , function(data) {

                          if(data.success)
                          {

                              data.product.quantity = 1;

                              $rootScope.productsSelected.push(data.product);

                              $scope.find = '';

                              $scope.autocomplete = false;

                              $scope.supplierSelected = {};

                              $scope.cost = '';

                              $scope.percent_gain = '';

                              $scope.suggested_price = '';

                              $scope.suggested_price_active = 0;

                              $scope.newSupplier = 0;

                              $(".image").html("");

                              $("input.imageProductInput").val('');

                              $(".close_modal").click();

                              $("#addproductForm").trigger("reset");

                              $rootScope.$digest();


                          }

                      });

                  }

              });

              $.extend($.validator.messages, {
                  required: "Este campo es requerido.",
                  remote: "dfasdfsd.",
                  email: "Ingresa un correo electrónico valido.",
                  date: "Ingresa una fecha válida.",
                  number: "Ingresa un número válido.",
                  digits: "Ingresa unicamente digitos.",
                  equalTo: "Please enter the same value again.",
                  accept: "Please enter a value with a valid extension.",
                  maxlength: jQuery.validator.format("Este campo debe contener minimo {0} caracteres."),
                  minlength: jQuery.validator.format("Este campo debe contener máximo {0} caracteres."),
                  rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                  range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                  max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                  min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
              });

          }
      }])

    .controller('ShowController', [ '$scope' , 'PackagesService'  , function ($scope , PackagesService  ) {



    }]);

})();