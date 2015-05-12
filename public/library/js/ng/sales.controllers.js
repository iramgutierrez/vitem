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

    .controller('FormController', [ '$rootScope' , '$scope', '$filter' , 'SalesService' , 'UsersService' , 'ClientsService' , 'ProductsService' , 'PackagesService' , 'DestinationsService' , function ($rootScope , $scope , $filter , SalesService,  UsersService , ClientsService , ProductsService , PackagesService , DestinationsService) {


      $scope.pay_types = {};

      SalesService
          .API('getPayTypes')
          .then(function (pay_types) {

              $scope.pay_types = pay_types;

          })

      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

      UsersService.API('getSellers').then(function (data) {

          $scope.sellersAll = data;

      });

      $scope.getSellersByStore = function()
      {

        var store_id = $scope.store_id || false;

        UsersService.API('getSellers' , { store_id : store_id }).then(function (data) {

          $scope.sellersAll = data;

        });
      }



      $scope.clients = {};

      ClientsService.all().then(function (data) {

          $scope.clientsAll = data;

      });

      $scope.showAddProducts = false;

      $scope.showAddPacks = true;

      $scope.tab = 'pack';

      $scope.find_product = '';

      $scope.autocompleteProduct = false;      

      $scope.products = {};

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

      $scope.productsOld = [];

      $scope.packsOld = [];


        $scope.searchSeller = function ()
        { 
          
            if($scope.find_seller.length != '')
            {
                $scope.sellers = UsersService.search($scope.find_seller , $scope.sellersAll , false , 1 , false , false , false , false );

                $scope.autocompleteSeller = true;

            }else{

                $scope.sellers = {};

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

          $scope.sellerSelectedInit = function (id)
          {

              if(id)
              {

                  UsersService.API('getUserById', {

                    'id' : id


                  }).then(function (seller) {

                      $scope.addSeller(seller);

                  });

              }

          }

          $scope.driverSelectedInit = function (id)
          {

              if(id)
              {

                  UsersService.API('getUserById', {

                      'id' : id


                  }).then(function (driver) {

                      $scope.addDriver(driver);

                  });

              }

          }

          $scope.clientSelectedInit = function (id)
          {

              if(id)
              {

                  ClientsService.API('getClientById', {

                      'id' : id


                  }).then(function (client) {

                      $rootScope.addClient(client)

                  });

              }

          }

          $scope.destinationSelectedInit = function (id)
          {

              if(id)
              {

                  DestinationsService.API('findById', {

                      'id' : id


                  }).then(function (destination) {

                      $scope.addDestination(destination);

                  });

              }

          }

        $scope.searchClient = function ()
        {
          
            if($rootScope.find_client.length != '')
            {
                $scope.clients = ClientsService.search($rootScope.find_client , $scope.clientsAll , false , 1 , false , false );

                $rootScope.autocompleteClient = true;

            }else{

                $scope.clients = {};

                $rootScope.autocompleteClient = false;

            }
            

        }

        $scope.searchProduct = function ()
        {
          
            if($scope.find_product.length != '')
            {

                $scope.products = ProductsService.search($scope.find_product , $scope.productsAll , $rootScope.productsSelected );

                $scope.autocompleteProduct = true;

            }else{

                $scope.products = {};

                $scope.autocompleteProduct = false;

            }
            

        }

        $scope.addProduct = function(product , quantity )
        { 

            if(!quantity)
            {
              quantity = 1;
            }
            product.quantity = quantity;

            product.stock_store = $scope.getStockPerStore(product , $scope.store_id);

            console.log(product.stock_store);

            product.quantity_null = false;

            if(!product.stock_store)
            {
              product.quantity_null = true;

              product.quantity = 0;
            }

            product.quantity_init = $scope.quantityInit(product);

            inProductsSelected = false;

            for (var p = 0, len = $rootScope.productsSelected.length; p < len; p++) {

                if($rootScope.productsSelected[p].id == product.id)
                {

                    $rootScope.productsSelected[p].quantity =  parseInt($rootScope.productsSelected[p].quantity) + parseInt(product.quantity);

                    inProductsSelected = true;

                    break;

                }


            }

            if(!inProductsSelected)
            {
                $rootScope.productsSelected.push(product);
            }

            $scope.find_product = '';

            $scope.autocompleteProduct = false;

            return false;
        }

        $scope.removeProduct = function (key)
        {

          $rootScope.productsSelected.splice(key, 1);

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

          angular.forEach(pack.products, function(product, key) {


              $scope.addProduct(product , product.pivot.quantity);
            

          });

            /*
            $scope.packsSelected.push(pack);*/

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

        $scope.addQuantity = function (quantity , stock , init)
        { 

          if(!init)
            init = 0;

          quantity = (isNaN(parseInt(quantity))) ? 0 : parseInt(quantity);

          stock = (isNaN(parseInt(stock))) ? false : parseInt(stock);

          stock = parseInt(stock) + parseInt(init);

          console.log(stock);

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
                
                    $rootScope.autocompleteClient = false;

                });

            }, 300);
            
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

            angular.forEach(data, function(product, key) {

              $scope.addProduct(product);

            });

          //$rootScope.productsSelected = data;

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

                //$rootScope.productsSelected.push(data);

                $scope.addProduct(data , data.quantity);

              });

          });

        }

        $scope.getPacksOld = function() {

            angular.forEach($scope.packsOld, function (value, key) {

                PackagesService.findById(value.pack_id).then(function (data) {

                    data.quantity = value.quantity;

                    $scope.packsSelected.push(data);

                });

            });

        }



        $scope.delivery_tab = 3;;

        $scope.deliverExists = false;

        $scope.find_driver = '';

      $scope.autocompleteDriver = false;

      $scope.drivers = {};

      UsersService.API('getDrivers').then(function (data) {

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

      
            $scope.delivery_employee_id = driver.employee.id;

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

      $scope.getFinalPrice = function()
      {

          var total = $scope.getTotalPrice();

          if($scope.delivery_tab == 1)
          {

              if($scope.destination.hasOwnProperty('cost'))
              {
                  total += $scope.destination.cost;


              }

          }

          return total;

      }

      $scope.getStockPerStore = function (product , store_id)
      { 

        var quantity = 0;

        if(product.hasOwnProperty('stores'))
        {

          angular.forEach(product.stores, function(store, key) {

            if(store.id == store_id)
            {
              quantity = store.pivot.quantity;
            }

          });

        }

        return quantity;

      }

      $scope.changeStore = function ()
      {

          $scope.getSellersByStore();

          $scope.employee_id = '';
          
          $scope.find_seller = '';

          $scope.autocompleteSeller = false;

          $rootScope.productsSelected = [];

          $rootScope.store_id = $scope.store_id;

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

          return value;


      }

    }])

    .controller('AddClientController', [ '$rootScope' ,'$scope' , function ($rootScope , $scope) {

          $scope.initJQuery = function(url_dropzone)
          {

              $("#imageClient").dropzone(
                  {
                      url:  url_dropzone,
                      previewTemplate : "",
                      paramName : "image_profile",
                      success : function(file , data) {

                          if(data.hasOwnProperty('success') && data.success)
                          {

                              $("#addclientForm").find(".image").html("<img style=\"width:250px;\" src=\""+data.path+'/'+data.filename+"\" />");

                              $("input.imageClientInput").val(data.filename);

                          }

                      }
                  }

              );

              var validate = $("#addclientForm").validate({

                  rules : {

                      name : {
                          required : true,
                          minlength : 4,
                          maxlength : 40
                      },
                      email : {
                          required : true,
                          email : true,
                          remote:
                          {
                              url: 'API/clients/checkEmail',
                              type: "get",
                              data:
                              {
                              },
                          }
                      },
                      street : {
                          required : true
                      },
                      inner_number : {
                          required : true
                      },
                      zip_code : {
                          required : true
                      },
                      phone : {
                          required : true
                      },
                      client_type_id : {
                          required : true
                      }
                  },
                  messages : {

                      email : {

                          remote : "El correo electrónico especificado ya esta en uso."

                      }

                  },
                  submitHandler : function(form)
                  {

                      $.post($("#addclientForm").attr('action') , $("#addclientForm").serialize() , function(data) {

                          if(data.success)
                          {

                              $rootScope.addClient(data.client);

                              $("#addclientForm").find(".image").html("");

                              $("input.imageClientInput").val('');

                              $("#addclientForm").find(".close_modal").click();

                              $("#addclientForm").trigger("reset");

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

                      console.log(data.product);

                      data.product.stock_store = $scope.getStockPerStore(data.product , $rootScope.store_id);

                      data.product.quantity_null = false;

                      if(!data.product.stock_store)
                      {
                        data.product.quantity_null = true;

                        data.product.quantity = 1;
                      }

                      data.product.quantity_init = $scope.quantityInit(data.product);

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

        $scope.getStockPerStore = function (product , store_id)
        { 

          var quantity = 0;

          if(product.hasOwnProperty('stores'))
          {

            angular.forEach(product.stores, function(store, key) {

              if(store.id == store_id)
              {
                quantity = store.pivot.quantity;
              }

            });

          }

          return quantity;

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

    

    .controller('SalePaymentController', [ '$scope' , 'SalesService' , 'UsersService' , function ($scope , SalesService , UsersService) {

      $scope.pay_types = {};

      SalesService
          .API('getPayTypes')
          .then(function (pay_types) {

              $scope.pay_types = pay_types;

          })

      $scope.sale_id = false;

      $scope.sheet = '';

      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id; 

        if(sale_id)
          $scope.getSale();

      }

      $scope.getSale = function()
      { 

        SalesService.API('findById' , {id : $scope.sale_id}).then(function (sale) {

            $scope.sale = sale;

            angular.forEach($scope.sale.sale_payments, function(value, key) {

              $scope.sale.sale_payments[key].in_commission = true;

            });

        });

      }

      $scope.setSaleSheet = function(sheet)
      {

        if(sheet != '')
        {

          $scope.sheet = sheet; 

          $scope.searchSaleBySheet();

        }

      }

      $scope.searchSaleBySheet = function()
      { 

        SalesService.API('findBySheet' , {sheet : $scope.sheet})

        .then(function (sale) { 

            $scope.error = false;

            if(!sale.hasOwnProperty('id'))
            {

              $scope.error = 'No se encontro la venta especificada';

              $scope.sale_id = false;

              $scope.sale = false;

            }
            else
            {

              $scope.sale = sale;

              $scope.sale_id = sale.id;

              angular.forEach($scope.sale.sale_payments, function(value, key) {

                $scope.sale.sale_payments[key].in_commission = true;

              });

              $scope.commission_type = $scope.getCommissionTypeInit();

              $scope.getTotalCommission();

              $scope.percent = 0;

              $scope.getTotal();

            }

            

        });

      }

      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

      UsersService.API('getSellers').then(function (data) {

            $scope.sellersAll = data;

      });

      $scope.searchSeller = function ()
      { 
          
            if($scope.find_seller.length != '')
            {
                $scope.sellers = UsersService.search($scope.find_seller , $scope.sellersAll , false , false , false , false , false , false );

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