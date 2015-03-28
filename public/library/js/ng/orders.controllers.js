(function () {

    angular.module('orders.controllers', [])

        .controller('OrdersController', ['$scope', '$filter' , 'OrdersService' , function ($scope ,  $filter , OrdersService ) {
            
            $scope.find = '';   
            $scope.sort = 'id';
            $scope.reverse = false;
            $scope.pagination = true;
            $scope.page = 1;
            $scope.perPage = 10;
            $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
            $scope.viewGrid = 'list';
            $scope.operatorOrderDate = '';
            $scope.orderDate = '';
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
              
              OrdersService.API(

                'find',
                {              
                  page : $scope.page ,
                  perPage : $scope.perPage , 
                  find : $scope.find , 
                  operatorOrderDate : $scope.operatorOrderDate , 
                  orderDate : $scope.orderDate

                }).then(function (data) {              

                    $scope.ordersP = data.data;

                    $scope.total = data.total;

                    $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                });  

            }

            $scope.init();

            OrdersService.all().then(function (data) {

              $scope.ordersAll = data;

              $scope.orders = data;

              $scope.search(true);

              $scope.paginate();     

            });

            $scope.paginate = function( p )
            {
              if($scope.pagination)
              {            

                if(p)
                  $scope.page = parseInt(p);   

                if(!$scope.ordersAll)
                {
                
                  $scope.init();

                }
                else
                {

                  $scope.total = $scope.orders.length;          

                  $scope.pages = Math.ceil( $scope.total / $scope.perPage );

                  $scope.ordersP = $scope.orders.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

                }

              }
              else
              {
                $scope.ordersP = $scope.orders
              }
            }



            $scope.search = function ( init )
            { 

              if(!$scope.ordersAll)
              {
              
                $scope.init();

              }
              else
              { 
                
                $scope.orders = OrdersService.search($scope.find , $scope.ordersAll , $scope.operatorOrderDate , $scope.orderDate);

                
              }

              if(!init){

                $scope.paginate(1);

              }

            }

            $scope.clear = function () 
            {
                $scope.find = '';   
              $scope.operatorOrderDate = '';
                $scope.orderDate = '';
                $scope.sort = 'id';
                $scope.reverse = false;
                $scope.orders = $scope.ordersAll;
              $scope.paginate(1);
              $scope.modal = false;

            }


        }])

       .controller('FormController', [ '$rootScope' , '$scope', '$filter' ,  'OrdersService' ,'ProductsService' , 'SuppliersService' , function ($rootScope , $scope , $filter , OrdersService,  ProductsService , SuppliersService) {

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

                OrdersService.getProducts(sale_id).then(function (data) {

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

        .controller('AddProductController', ['$rootScope' , '$scope' , 'SuppliersService'  , function ($rootScope , $scope , SuppliersService  ) {


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
                        /*description : {
                            required : true
                        },
                        stock : {
                            required : true,
                            number : true
                        },*/
                        price : {
                            required : true,
                            number : true
                        },
                        cost : {
                            required : true,
                            number : true
                        },
                        /*production_days : {
                            required : true,
                            number : true 
                        },*/
                        user_id : {
                            required : true
                        },
                        supplier_id : {
                            required : true
                        }
                    },
                    messages : {

                        key : {

                            remote : "El código especificado ya esta en uso."

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

        .controller('AddSupplierController', ['$rootScope' , '$scope' , function ($rootScope , $scope  ) {

            $scope.initJQuery = function()
            {



                var validate = $("#addsupplierForm").validate({

                    rules : {

                        'name' : {
                            required : true,
                            minlength : 4,
                            maxlength : 40
                        },
                        'email' : {
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
                        'street' : {
                            required : true
                        },
                        'outer_number' : {
                            required : true
                        },
                        'zip_code' : {
                            required : true
                        },
                        'phone' : {
                            required : true
                        }
                    },
                    messages : {

                        'supplier[email]' : {

                            remote : "El correo electrónico especificado ya esta en uso."

                        }
                    },
                    submitHandler : function(form)
                    {

                        $.post($("#addsupplierForm").attr('action') , $("#addsupplierForm").serialize() , function(data) {

                            if(data.success)
                            {

                                $rootScope.addSupplier(data.supplier);

                                $("#addsupplierForm").find(".close_modal").click();

                                $("#addsupplierForm").trigger("reset");

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


        .controller('ShowController', [ '$scope'  , function ($scope ) {



        }]);

})();