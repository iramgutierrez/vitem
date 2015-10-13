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

        /*Generar XLS */

        $scope.filename = 'reporte_productos';

        $scope.dataExport = false;

        $scope.headersExport = JSON.stringify([
          {
            field : 'id',
            label : 'Id'
          },
          {
            field : 'key',
            label : 'Código'
          },
          {
            field : 'name',
            label : 'Nombre'
          },
          {
            field : 'username',
            label : 'Nombre de usuario'
          },
          {
            field : {
              role : 'name'
            },
            label : 'Tipo de usuario'
          },
          {
            field : {
              store : 'name'
            },
            label : 'Sucursal'
          },
          {
            field : {
              employee : 'salary'
            },
            label : 'Salario'
          },
          {
            field : {
              employee : 'entry_date'
            },
            label : 'Fecha de ingreso'
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

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.products);

          /*Generar XLS */

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

            /*Generar XLS */

            $scope.dataExport = $scope.generateJSONDataExport($scope.products);

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
          $scope.status = '';
          $scope.sort = 'id';
          $scope.reverse = false;
          $scope.products = $scope.productsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'SuppliersService'  , 'ColorService', 'ProductsService', function ($scope , SuppliersService , ColorService , ProductsService ) {

      $scope.status = 'No disponible';
      $scope.find = '';
      $scope.autocomplete = false;
      $scope.supplierSelected = {};

      SuppliersService.all().then(function (data) {

        $scope.countriesAll = data;

      });



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

        $scope.checkQuantityByStore = function(store_id)
        {

          quantity = $scope.ProductStore[store_id].quantity;

          if(!isNaN(quantity) )
          {

            if($scope.restrict == 1)
            {
              var stock = $scope.stock;

              var pre = $scope.ProductStore[store_id].quantity_pre;

              var init = $scope.ProductStore[store_id].quantity_init;

              var diff = parseInt(quantity) - parseInt(pre);

              stock -= diff;

              if(stock <= 0)
              {

                quantity = quantity + stock;

                stock = 0;

              }

              $scope.stock = stock;

            }

          }
          else
          {
            quantity = $scope.ProductStore[store_id].quantity_init;
          }

          $scope.ProductStore[store_id].quantity_pre = quantity;

          $scope.ProductStore[store_id].quantity = quantity;

        }

        $scope.min = 0;

        $scope.quantity_color = 0;

        $scope.allColors = [];

        $scope.initColors = function(product_id)
        {

          var product_id = product_id || false;

          ColorService.API('all')
            .then(function(colors){

              if(!$scope.allColors.length && !$scope.colors.length)
              {

                $scope.allColors = colors;

              }

              if(product_id){
                ProductsService.API('getColorProduct' , { id : product_id})
                  .then(function (colorsP) {

                    angular.forEach(colorsP , function(c , i) {

                      if($scope.allColors){

                        $scope.addColorI(c);
                      }
                      else
                      {
                        ColorService.API('all')
                          .then(function(colors){ console.log('aqui')

                            $scope.allColors = colors;

                            $scope.addColorI(c);

                          })
                      }

                    });


                  })
              }

            })
        }

        $scope.addColorI = function(colorI)
        {
          var color = false;

          angular.forEach($scope.allColors , function(c , i){

            if(c.id == colorI.id)
            {
              color = c;

              color.color_id = i;
            }

          });

          if(color)
          {

            color.quantity = colorI.pivot.quantity;

            $scope.colors.push(color);

            $scope.allColors.splice( color.color_id , 1);

            $scope.selectColors = false;

            $scope.quantity_color = 0;

          }
        }

        $scope.calculateMin = function()
        {

          var min = 0;

          if($scope.stock < 1){
            min = 0;
          }

          $scope.min = min;

        }

        $scope.colors = [];

        $scope.addColor = function()
        {
          var color = false;

          angular.forEach($scope.allColors , function(c , i){

            if(c.id == $scope.selectColors)
            {
              color = c;

              color.color_id = i;
            }

          })

          if(color)
          {

            color.quantity = $scope.quantity_color;

            $scope.colors.push(color);

            $scope.allColors.splice( color.color_id , 1);

            $scope.selectColors = false;

            $scope.quantity_color = 0;

          }
        }

        $scope.validAddColor = function()
        {

          return !($scope.stock && $scope.selectColors && $scope.quantity_color >= 0) ? true : false ;
        }

        $scope.stock = 0;

        $scope.calculateMax = function()
        {

          var max = $scope.stock;

          angular.forEach($scope.colors , function (color , i) {
            max -= color.quantity;
            if(max < 0)
              max = 0;
          })

          return max;

        }
        $scope.calculateNotAssigned = function()
        {

          var max = $scope.stock;

          angular.forEach($scope.colors , function (color , i) {
            max -= color.quantity;
            /*if(max < 0)
              max = 0;*/
          })

          return max;

        }

        $scope.removeColor = function(color)
        {
          var color_key = false;

          angular.forEach($scope.colors , function(c , i ){
            if(c.id == color.id)
              color_key = i
          })


          if(color_key >= 0)
          {

            $scope.allColors.push(color);

            $scope.colors.splice(color_key , 1);

          }


        }

        $scope.updateColor = function(color)
        {

          var color_key = false;

          angular.forEach($scope.colors , function(c , i ){
            if(c.id == color.id)
              color_key = i
          })


          if(color_key >= 0)
          {
            $scope.allColors.push(color);

            $scope.selectColors = color.id;

            $scope.quantity_color = color.quantity;

            $scope.colors.splice(color_key , 1);
          }

        }

        $scope.notColor = false;

        ColorService.

          API('getNotAssignedId')

          .then(function(color) {

            $scope.notColor = color;

            $scope.notColor.quantity = $scope.stock;

          })

        $scope.colorsOld = [];

        $scope.getColorsOld = function(){

          ColorService.API('all')
            .then(function(colors){

              $scope.allColors = colors;

              angular.forEach($scope.colorsOld , function(color , i) {

                if(color.color_id != $scope.notColor.id)
                {
                    $scope.addColorInit(color)
                }

              });

            })

        }

        $scope.addColorInit = function(colorInit)
        {

          var color = false;

          angular.forEach($scope.allColors , function(c , i){

            if(c.id == parseInt(colorInit.color_id))
            {
              color = c;

              color.color_id = i;
            }

          })

          if(color)
          {

            color.quantity = colorInit.quantity;

            $scope.colors.push(color);

            angular.forEach($scope.allColors , function(c , i ){

              if(color.slug == c.slug)
              {
                console.log(color)

                $scope.allColors.splice( i , 1);

              }

            })

          }
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