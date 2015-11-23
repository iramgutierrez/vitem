(function () {

  angular.module('discounts.controllers', []) 

    .controller('DiscountsController', ['$scope', '$filter' , 'DiscountsService' , function ($scope ,  $filter , DiscountsService ) {
        
        $scope.find = '';
          $scope.type = '';
          $scope.initDate = '';
          $scope.endDate = '';
          $scope.discountType = '';
          $scope.store = '';
          $scope.payType = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        /*Generar XLS */

        $scope.filename = 'reporte_descuentos';

        $scope.dataExport = false;

        $scope.headersExport = JSON.stringify([
          {
            field : 'id',
            label : 'Id'
          },
          {
            field : {
              sale: 'sheet'
            },
            label : 'Folio de venta'
          },
          {
            field : {
              employee: {
                user : 'name'
              }
            },
            label : 'Chofer'
          },
          {
            field : {
              destination: 'value_string'
            },
            label : 'Tipo de destino'
          },
          {
            field : {
              destination: 'value_type'
            },
            label : 'Destino'
          },
          {
            field : 'address',
            label : 'Direción'
          },
          {
            field : 'discount_date',
            label : 'Fecha de entrega'
          },
          {
            field : 'subtotal',
            label : 'Total de la entrega'
          },
          {
            field : {
              pay_type: 'name'
            },
            label : 'Forma de pago'
          },
          {
            field : 'commission_pay',
            label : 'Comisión por forma de pago'
          },
          {
            field : 'total',
            label : 'Total en caja'
          },
        ]);   

        $scope.generateJSONDataExport = function( data )
        { 

          return JSON.stringify(data);

        }

        /*Generar XLS */


        $scope.init = function() 
        { 
          
          DiscountsService.API(

            'find',
            {              
              page : $scope.page ,
              perPage : $scope.perPage ,
              find : $scope.find ,
              type : $scope.type ,
                initDate : (angular.isDate($scope.initDate)) ? $scope.initDate.format('yyyy-mm-dd') : '' ,
                endDate : (angular.isDate($scope.endDate)) ? $scope.endDate.format('yyyy-mm-dd') : '' ,
                discountType : $scope.discountType ,
                store : $scope.store ,
                payType : $scope.payType ,

            }).then(function (data) {

                $scope.discountsP = data.data;

                $scope.total = data.total;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });  

        }

        $scope.init();

        DiscountsService.all().then(function (data) {

          //$scope.discountsAll = data;

          $scope.discounts = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.discounts);  

          /*Generar XLS */      

          $scope.search(true);

          $scope.paginate();     

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);   

            if(!$scope.discountsAll)
            {
            
              $scope.init();

            }
            else
            {  

              $scope.total = $scope.discounts.length;          

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.discountsP = $scope.discounts.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.discountsP = $scope.discounts
          }
        }



        $scope.search = function ( init )
        { 

          if(!$scope.discountsAll)
          {
          
            $scope.init();

          }
          else
          {

            $scope.discounts = DiscountsService.search(
                $scope.find ,
                $scope.discountsAll ,
                $scope.type ,
                (angular.isDate($scope.initDate)) ? $scope.initDate.format('yyyy-mm-dd') : $scope.initDate ,
                (angular.isDate($scope.endDate)) ? $scope.endDate.format('yyyy-mm-dd') : $scope.endDate,
                $scope.discountType,
                $scope.store,
                $scope.pay_type
            );

            /*Generar XLS */

            $scope.dataExport = $scope.generateJSONDataExport($scope.discounts);  

            /*Generar XLS */      

            
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
          $scope.discounts = $scope.discountsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])   

    .controller('FormController', [ '$scope' , '$filter' ,'ProductsService' , 'PackagesService' , 'PayTypeService' , 'StoresService' , function ($scope , $filter , ProductsService , PackagesService, PayTypeService , StoresService) {


          $scope.tab = 'pack';

          $scope.find_product = '';

          $scope.autocompleteProduct = false;

          $scope.products = {};

          $scope.productsAll = false;

          ProductsService.all().then(function (data) {

              $scope.productsAll = data;

          });

          $scope.find_pack = '';

          $scope.autocompletePack = false;

          $scope.packs = {};

          PackagesService.all().then(function (data) {

              $scope.packsAll = data;

          });

          $scope.searchProduct = function ()
          {

              if($scope.find_product.length != '')
              {

                  $scope.products = ProductsService.search($scope.find_product , $scope.productsAll , $scope.productsSelected );

                  $scope.autocompleteProduct = true;

              }else{

                  $scope.products = {};

                  $scope.autocompleteProduct = false;

              }


          }

          $scope.uniqueItem = {};

          $scope.getDiscountPrice = function()
          {
              if($scope.type == 1)
              {
                  if(
                      angular.isDefined($scope.discountType) &&
                      angular.isDefined($scope.quantity) &&
                      !isNaN($scope.quantity)
                  )
                  {
                      if($scope.discountType == 'percent')
                      {
                          $scope.uniqueItem.discount_price = $scope.uniqueItem.price - (($scope.uniqueItem.price * $scope.quantity) / 100);
                      }
                      else if($scope.discountType == 'quantity')
                      {
                          $scope.uniqueItem.discount_price = $scope.uniqueItem.price - $scope.quantity;
                      }
                      else
                      {
                          $scope.uniqueItem.discount_price = $scope.uniqueItem.price;
                      }

                      if($scope.uniqueItem.discount_price < 0)
                      {
                          $scope.uniqueItem.discount_price = 0;
                      }
                  }
                  else
                  {
                      $scope.uniqueItem.discount_price = $scope.uniqueItem.price;
                  }
              }
          }

          $scope.addUniqueItem = function(item , type)
          {
              item.type = type;

              item.quantity = 1;

              $scope.uniqueItem = item;

              $scope.getDiscountPrice();
          }

          $scope.addProduct = function(product , quantity )
          {
              if($scope.type == 1){

                  $scope.addUniqueItem(product , 'product');
              }

              $scope.find_product = '';

              $scope.autocompleteProduct = false;

              return false;
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

              pack.price = $scope.getPackPrice(pack);

              if($scope.type == 1)
              {
                  $scope.addUniqueItem(pack, 'pack');
              }

              $scope.find_pack = '';

              $scope.autocompletePack = false;

              return false;
          }

          $scope.getPackPrice = function(pack){

              var price = 0;

              angular.forEach(pack.products , function(product){

                  price = parseFloat(price) +parseFloat(product.price);
              })

              return price;
          }

          $scope.addQuantity = function (quantity , stock , init)
          {

              if(!init)
                  init = 0;

              quantity = (isNaN(parseInt(quantity))) ? 0 : parseInt(quantity);

              stock = (isNaN(parseInt(stock))) ? false : parseInt(stock);

              stock = parseInt(stock) + parseInt(init);

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

          $scope.checkValuePreOrOld = function (pre , old , def)
          {
              var isArray = isArray || false;
              if(!def)
                def = '';

              var value = def;

              if(pre)
                value = pre;

              if(old)
                  value = old;

              return value;


          }

          $scope.payTypes = [];

          $scope.getPayTypes = function(payTypes)
          {
              $scope.allPayTypes = [];

              PayTypeService.API('all').then(function(pay_types) {

                  $scope.allPayTypes = pay_types;

                  if(payTypes != '')
                  {
                      var realPayTypes = [];

                      var payTypesObject = JSON.parse(payTypes);

                      angular.forEach(payTypesObject , function(pay){

                          realPayTypes[realPayTypes.length] = $scope.allPayTypes[pay];
                      });

                      $scope.payTypes =  realPayTypes;

                      console.log($scope.payTypes );
                  }



              });
          }

          $scope.allStores = [];

          $scope.getStores = function(storesV)
          {
              $scope.allStores = [];

              StoresService.API('all').then(function(stores) {

                  $scope.allStores = stores;

                  if(storesV != '')
                  {
                      var realStores = [];

                      var storesObject = JSON.parse(storesV);

                      angular.forEach(storesObject , function(pay){

                          realStores[realStores.length] = $scope.allStores[pay];
                      });

                      $scope.stores =  realStores;

                      console.log($scope.stores );
                  }



              });
          }

          StoresService.API('all').then(function(stores) {

              $scope.allStores = stores;

          });

    }]) 

    .controller('EditController', [ '$scope' , '$filter' , '$q' ,'SalesService' , 'UsersService' , 'DiscountsService' , 'DestinationsService' , function ($scope , $filter , $q ,SalesService , UsersService , DiscountsService , DestinationsService) {

      $scope.pay_types = {};

      SalesService
          .API('getPayTypes')
          .then(function (pay_types) {

              $scope.pay_types = pay_types;

          })


      $scope.init = function(id)
      {

        DiscountsService.API('findById' , {id : id}).then(function (discount) {

          $scope.discount = discount;

          $scope.sale = discount.sale;   

          $scope.sale_id = discount.sale.id;     

          $scope.employee_id = $scope.discount.employee_id; 

          $scope.find_driver = $scope.discount.employee.user.name;   

          $scope.destination_id = $scope.discount.destination_id; 

          $scope.find_destination = $filter('destination_types')($scope.discount.destination.type) + ': ' + $scope.discount.destination.value_type; 

          $scope.destination = $scope.discount.destination;

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
              dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

          };

        })

      }


      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id; 

        $scope.getSale();

      }

      $scope.getSale = function()
      { 

        SalesService.API('findById' , {id : $scope.sale_id}).then(function (sale) {

            $scope.sale = sale;

            angular.forEach($scope.sale.sale_payments, function(value, key) {


              $scope.sale.sale_payments[key].in_commission = true;

            });

        }).then(function(){

          $scope.commission_type = $scope.getCommissionTypeInit();

        }).then(function(){

          $scope.getTotalCommission();

          $scope.percent = 0;

          $scope.getTotal();

        });

      }  

      $scope.find_driver = '';

      $scope.autocompleteDriver = false;

      $scope.drivers = {};

      UsersService.API('getSellers').then(function (data) {

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

      $scope.checkNewDestination = function()
      {

        if($scope.newDestination === 1)
        {

          

        }
        else
        {



        }


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



    }])
      .filter('type' , function () {
          return function (type) {

              var types = {
                  1 : 'Por producto/paquete',
                  2 : 'Por venta'
              };

              return types[type] || '';
          }
      })
      .filter('discountType' , function () {
          return function (discountType) {

              var discountTypes = {
                  'percent' : 'Porcentaje',
                  'quantity' : 'Cantidad'
              };

              return discountTypes[discountType] || '';
          }
      })
      .filter('quantityDiscountType' , function ($filter) {
          return function (discount) {

              if(discount.discount_type == 'percent')
              {
                  return discount.quantity+'%';
              }
              else if(discount.discount_type == 'quantity')
              {
                  return $filter('currency')(discount.quantity);
              }


              return discount.quantity;
          }
      })


})();