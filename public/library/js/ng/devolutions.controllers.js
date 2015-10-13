(function () {

    angular.module('devolutions.controllers', [])

        .controller('DevolutionsController', ['$scope', '$filter' , 'DevolutionsService' , function ($scope ,  $filter , DevolutionsService ) {

            $scope.find = '';
            $scope.sort = 'id';
            $scope.reverse = false;
            $scope.pagination = true;
            $scope.page = 1;
            $scope.perPage = 10;
            $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
            $scope.viewGrid = 'list';
            $scope.operatorDevolutionDate = '';
            $scope.devolutionDate = '';
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

            /*Generar XLS */

            $scope.filename = 'reporte_pedidos';

            $scope.dataExport = false;

            $scope.headersExport = [
              {
                field : 'id',
                label : 'Id'
              },
              {
                field : {
                  supplier: 'name'
                },
                label : 'Proveedor'
              },
              {
                field : 'devolution_date',
                label : 'Fecha de llegada'
              },
              {
                field : 'total',
                label : 'Total'
              },
            ];

            DevolutionsService.API('getMaxProducts').then(function (count) {

              for(c = 0; c < count; c++)
              {
                products = []

                products[c] = 'name';

                $scope.headersExport.push({
                  field : {
                    products : products
                  },
                  label : 'Producto ' + (c+1)
                });

                products = []

                products[c] = {
                  'pivot' : 'quantity'
                };

                $scope.headersExport.push({
                  field : {
                    products : products
                  },
                  label : 'Cantidad de producto ' + (c+1)
                })
              }

              $scope.headersExport = JSON.stringify($scope.headersExport);

            });

            $scope.generateJSONDataExport = function( data )
            {

              return JSON.stringify(data);

            }

            /*Generar XLS */

            $scope.init = function()
            {

              DevolutionsService.API(

                'find',
                {
                  page : $scope.page ,
                  perPage : $scope.perPage ,
                  find : $scope.find ,
                  operatorDevolutionDate : $scope.operatorDevolutionDate ,
                  devolutionDate : $scope.devolutionDate

                }).then(function (data) {

                    $scope.devolutionsP = data.data;

                    $scope.total = data.total;

                    $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                });

            }

            $scope.init();

            DevolutionsService.all().then(function (data) {

              $scope.devolutionsAll = data;

              $scope.devolutions = data;

              /*Generar XLS */

              $scope.dataExport = $scope.generateJSONDataExport($scope.devolutions);

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

                if(!$scope.devolutionsAll)
                {

                  $scope.init();

                }
                else
                {

                  $scope.total = $scope.devolutions.length;

                  $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                  $scope.devolutionsP = $scope.devolutions.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

                }

              }
              else
              {
                $scope.devolutionsP = $scope.devolutions
              }
            }



            $scope.search = function ( init )
            {

              if(!$scope.devolutionsAll)
              {

                $scope.init();

              }
              else
              {

                $scope.devolutions = DevolutionsService.search($scope.find , $scope.devolutionsAll , $scope.operatorDevolutionDate , $scope.devolutionDate);

                  /*Generar XLS */

                  $scope.dataExport = $scope.generateJSONDataExport($scope.devolutions);

                  /*Generar XLS */


              }

              if(!init){

                $scope.paginate(1);

              }

            }

            $scope.clear = function ()
            {
                $scope.find = '';
              $scope.operatorDevolutionDate = '';
                $scope.devolutionDate = '';
                $scope.sort = 'id';
                $scope.reverse = false;
                $scope.devolutions = $scope.devolutionsAll;
              $scope.paginate(1);
              $scope.modal = false;

            }


        }])

       .controller('FormController', [ '$rootScope' , '$scope', '$filter' ,  'DevolutionsService' ,'ProductsService' , 'SuppliersService' , function ($rootScope , $scope , $filter , DevolutionsService,  ProductsService , SuppliersService) {

            $scope.suppliers = {};

            SuppliersService.all().then(function (data) {

                $scope.suppliersAll = data;

            });

            $scope.searchSupplier = function ()
            {

                if($scope.find_supplier.length != '')
                {
                    $scope.suppliers =  SuppliersService.search($rootScope.find_supplier , $scope.suppliersAll , 1 );

                    $rootScope.autocompleteSupplier = true;

                }else{

                    $scope.suppliers = {};

                    $rootScope.autocompleteSupplier = false;

                }


            }

            $scope.supplierSelectedInit = function (id)
            {

                if(id)
                {

                    SuppliersService.API('findById', {

                        'id' : id


                    }).then(function (supplier) {

                        $rootScope.addSupplier(supplier , true);

                    });

                }

            }

            $scope.productSelectedInit = function (id)
            {

                if(id)
                {

                    ProductsService.findById(id).then(function (data) {

                        data.quantity = 1;

                        $rootScope.productsSelected.push(data);

                    });

                }

            }


            $scope.find_product = '';

            $scope.autocompleteProduct = false;

            $scope.products = {};

            $scope.productsAll = [];

            ProductsService.all().then(function (data) {

                $scope.productsAll = data;

            });

            $scope.productsOld = [];

            $scope.searchProduct = function ()
            {

                if($scope.find_product.length != '')
                {
                    $scope.products = ProductsService.search($scope.find_product , $scope.productsAll , $rootScope.productsSelected , $rootScope.supplier_id );

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

            $scope.addQuantity = function (quantity)
            {

                quantity = (isNaN(parseInt(quantity))) ? 0 : parseInt(quantity);

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

            $scope.costPerQuantity = function( cost , quantity)
            {

                cost = (isNaN(parseFloat(cost))) ? 0 : parseFloat(cost);

                quantity = (isNaN(parseFloat(quantity))) ? 1 : parseFloat(quantity);

                return cost * quantity;

            }

            $scope.getTotalCost = function()
            {

                var cost = 0;

                angular.forEach($rootScope.productsSelected, function(value, key) {

                    cost += $scope.costPerQuantity(value.cost , value.quantity);


                });

                return cost;

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

            $scope.getProductsSelected = function (sale_id)
            {

                DevolutionsService.getProducts(sale_id).then(function (data) {

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

            $scope.getProductsOld = function()
            {

                angular.forEach($scope.productsOld, function(value, key) {

                    ProductsService.findById(value.product_id).then(function (data) {

                        data.quantity = value.quantity;

                        $rootScope.productsSelected.push(data);

                    });

                });

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