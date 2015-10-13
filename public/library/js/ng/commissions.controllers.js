(function () {

  angular.module('commissions.controllers', [])

    .controller('CommissionsController', ['$scope', '$filter' , 'CommissionsService' , function ($scope ,  $filter , CommissionsService ) {

        $scope.find = '';
        $scope.type = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        /*Generar XLS */

        $scope.filename = 'reporte_comisiones';

        $scope.dataExport = false;

        $scope.headersExport = JSON.stringify([
          {
            field : 'id',
            label : 'Id'
          },
          {
            field : 'cost',
            label : 'Costo'
          },
          {
            field : 'value_string',
            label : 'Tipo'
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
            field : 'town',
            label : 'Ciudad'
          },
          {
            field : 'state',
            label : 'Estado'
          }
        ]);

        $scope.generateJSONDataExport = function( data )
        {

          return JSON.stringify(data);

        }

        /*Generar XLS */

        $scope.init = function()
        {

          CommissionsService.API(

            'all',
            {
              page : $scope.page ,
              perPage : $scope.perPage ,
              find : $scope.find ,
              type : $scope.type ,

            }).then(function (data) {

                $scope.commissionsP = data;

                $scope.total = data.length;

                $scope.pages = Math.ceil( $scope.total / $scope.perPage );

            });

        }

        $scope.init();

        CommissionsService.API('all').then(function (data) {

          $scope.commissionsAll = data;

          $scope.commissions = data;

          /*Generar XLS */

          $scope.dataExport = $scope.generateJSONDataExport($scope.commissions);

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

            if(!$scope.commissionsAll)
            {

              $scope.init();

            }
            else
            {

              $scope.total = $scope.commissions.length;

              $scope.pages = Math.ceil( $scope.total / $scope.perPage );

              $scope.commissionsP = $scope.commissions.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

            }

          }
          else
          {
            $scope.commissionsP = $scope.commissions;
          }

        }

        $scope.search = function ( init )
        {

          if(!$scope.commissionsAll)
          {

            $scope.init();

          }
          else
          {

            $scope.commissions = CommissionsService.search($scope.find , $scope.commissionsAll );

            /*Generar XLS */

            $scope.dataExport = $scope.generateJSONDataExport($scope.commissions);

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
          $scope.commissions = $scope.commissionsAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'SalesService' , 'UsersService' , '$filter' , function ($scope , SalesService , UsersService , $filter) {

      $scope.sale_id = false;

      $scope.sheet = '';

      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id;

        $scope.getSale();

      }

      $scope.setEmployeeId = function(employee_id)
      {

        $scope.employee_id = employee_id;

        //$scope.getEmployee();

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

        .then(function (sale) { console.log(sale);

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

      $scope.getEmployee = function()
      {

          UsersService.API('getEmployeeById' , {id : $scope.employee_id})

              .then(function (employee) {

                  $scope.employee_id = employee.employee.id;

                  $scope.find_seller = employee.name;

                  $scope.autocompleteSeller = false;

                  $scope.employee = employee;

              });

      }


      $scope.all_sale_payments = true;

      $scope.getTotalCommission = function()
      {

        if($scope.commission_type == 'total')
        {
          $scope.total_commission = $scope.sale.total
        }
        else
        {
          var total_commission = 0;

          angular.forEach($scope.sale.sale_payments, function(value, key) {

              if(value.in_commission)
              {

                total_commission += parseFloat(value.subtotal);

              }

          });

          $scope.total_commission = total_commission;
        }

      }

      $scope.getTotals = function()
      {

        $scope.getTotalCommission();

        $scope.getTotal();

      }
      $scope.getTotal = function()
      {

        var total = 0;

        if(!isNaN($scope.percent) && !isNaN($scope.total_commission))
        {

          total = ($scope.total_commission * $scope.percent ) / 100;

        }

        $scope.total = total;

      }

      $scope.getCommissionTypeInit = function()
      {

        var commission_type;

        if($scope.sale.sale_type == 'contado')
        {
          commission_type = 'total';

        }else{

          commission_type = 'sale_payments';

        }

        return commission_type;

      }

      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

      UsersService.API( 'all').then(function (data) {

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

      $scope.error_percent = false;

      $scope.error_total_commission = false;

      $scope.commissions = [];

      $scope.addCommission = function()
      {
        var error = false;

        $scope.error_percent = false;

        $scope.error_total_commission = false;

        $scope.error_employee = false;

        $scope.error_date = false;

        if(!$scope.date)
        {
          error = true;
          $scope.error_date = 'Debe asignar una fecha';

        }

        if(isNaN($scope.percent))
        {
          error = true;
          $scope.error_percent = 'El porcentaje de comisión debe ser un número';

        }else
        {
          if($scope.percent === 0)
          {
            error = true;
            $scope.error_percent = 'El porcentaje de comisión debe ser mayor a cero';
          }
        }

        if($scope.total_commission === 0)
        {

          error = true;
          $scope.error_total_commission = 'La cantidad total sobre la que se aplicara la comisión debe ser mayor a cero';

        }

        /*if(!$scope.employee_id || !$scope.find_seller)
        {

          error = true;
          $scope.error_employee = 'Debes seleccionar un vendedor';
        }*/

        if(!error)
        {

          var commission = {

            employee_id : $scope.employee_id,

            employee_name : $scope.find_seller,

            percent : $scope.percent,

            date : $filter('date')($scope.date,'yyyy-MM-dd HH:mm:ss'),

            status_pay : $scope.status_pay,

            total_commission : $scope.total_commission,

            total : $scope.total,

            type : $scope.commission_type,

            SalePayments : {}

          }

          if(commission.type == 'sale_payments')
          {

            angular.forEach($scope.sale.sale_payments, function(value, key) {

              if(value.in_commission)
              {

                commission.SalePayments[value.id] = true;

              }

            });

          }

          $scope.commissions.push(commission);

          $scope.employee_id = '';

          $scope.find_seller = '';

          $scope.percent = 0;

          $scope.total = 0;

        }



      }

      $scope.deleteCommission = function(id)
      {

        $scope.commissions.splice(id, 1);

      }



      $scope.checkValuePreOrOld = function (pre , old , def , date)
      {

          var date = date || false;

          if(!def)
              def = '';

          var value = def;

          if(pre)
              value = pre;

          if(old)
              value = old;

          if(date)
          {
            value = new Date(value)
          }

          return value;


      }

    }])

    .controller('SalesController', ['$scope', '$filter' , 'SalesService' , 'UsersService' , 'ClientsService' , function ($scope ,  $filter , SalesService , UsersService , ClientsService ) {

        $scope.find = '';
        $scope.sale_type = '';
        $scope.pay_type_id = '';
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
        $scope.initDate = '';
        $scope.endDate = '';
        $scope.percent_cleared_payment_type = '';
        $scope.percent_cleared_payment = '';

        $scope.employee_id = '';

        $scope.find_seller = '';

        $scope.autocompleteSeller = false;

        $scope.sellers = {};

        $scope.seller = {};

        UsersService.API('getSellers').then(function (data) {

            $scope.sellersAll = data;

        });

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

            $scope.seller = seller;

            $scope.autocompleteSeller = false;

            $scope.search();

            return false;
        }

        $scope.blurSeller = function()
        {

          if($scope.find_seller == '')
          {
            $scope.employee_id = '';

            $scope.seller = {};

            $scope.search();
          }
          else
          {
            if($scope.seller.hasOwnProperty('name'))
            {
              $scope.find_seller = $scope.seller.name;
            }
            else
            {
              $scope.find_seller = '';
            }
          }

          $scope.hideItems();

        }

        $scope.client_id = '';

        $scope.find_client = '';

        $scope.autocompleteClient = false;

        $scope.clients = {};

        $scope.client = {};

        ClientsService.all().then(function (data) {

            $scope.clientsAll = data;

        });

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

            $scope.client = client;

            $scope.autocompleteClient = false;

            $scope.search();

            return false;
        }



        $scope.blurClient = function()
        {
          if($scope.find_client == '')
          {
            $scope.client_id = '';

            $scope.client = {};

            $scope.search();
          }
          else
          {
            if($scope.client.hasOwnProperty('name'))
            {
              $scope.find_client = $scope.client.name;
            }
            else
            {
              $scope.find_client = '';
            }
          }

          $scope.hideItems();

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

        $scope.init = function()
        {

          SalesService.API(

            'findReport',
            {
              page : $scope.page ,
              perPage : $scope.perPage ,
              employee_id : $scope.employee_id,
              client_id : $scope.client_id,
              sale_type : $scope.sale_type ,
              pay_type_id : $scope.pay_type_id,
              percent_cleared_payment_type : $scope.percent_cleared_payment_type,
              percent_cleared_payment : $scope.percent_cleared_payment,
              initDate : (angular.isDate($scope.initDate)) ? $scope.initDate.format('yyyy-mm-dd') : $scope.initDate,
              endDate : (angular.isDate($scope.endDate)) ? $scope.endDate.format('yyyy-mm-dd') : $scope.endDate

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

            $scope.sales = SalesService.search2($scope.employee_id , $scope.client_id , $scope.salesAll , $scope.sale_type , $scope.pay_type_id, (angular.isDate($scope.initDate)) ? $scope.initDate.format('yyyy-mm-dd') : $scope.initDate , (angular.isDate($scope.endDate)) ? $scope.endDate.format('yyyy-mm-dd') : $scope.endDate , $scope.percent_cleared_payment_type , $scope.percent_cleared_payment);


          }

          if(!init){

            $scope.paginate(1);

          }

        }

        $scope.clear = function ()
        {
          $scope.employee_id = '';
          $scope.client_id = '';
          $scope.sale_type = '';
          $scope.pay_type = '';
          $scope.initDate = '';
          $scope.endDate = '';
          $scope.sort = 'id';
          $scope.reverse = false;
          $scope.sales = $scope.salesAll;
          $scope.paginate(1);
          $scope.modal = false;

        }

        //$scope.commissions = [];

        $scope.commissionsJson = '';

        $scope.allSales = false;

        $scope.selectAllSales = function()
        {
          console.log($scope.allSales);

          angular.forEach($scope.sales , function(sale , s){

            $scope.sales[s].addCommission = $scope.allSales;

          })

          $scope.updateCommissions();
        }

        $scope.updateCommissions = function(id)
        {
          var id = id || false;

          var commissions = [];

          angular.forEach($scope.sales , function(sale , c){

            if(sale.addCommission)
            {
              commissions.push(sale.id);
            }
          })

          $scope.commissionsJson = JSON.stringify(commissions);
        }


    }])

    .controller('CreateManyController', [ '$scope' , 'SalesService' , 'UsersService' , '$filter' , function ($scope , SalesService , UsersService , $filter) {

      $scope.sale_id = false;

      $scope.sheet = '';

      $scope.sales = [];

      $scope.setSaleId = function(sale_id)
      {

        $scope.sale_id = sale_id;

        $scope.getSale();

      }

      $scope.setEmployeeId = function(employee_id)
      {

        $scope.employee_id = employee_id;

        //$scope.getEmployee();

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

        .then(function (sale) { console.log(sale);

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

      $scope.getEmployee = function()
      {

          UsersService.API('getEmployeeById' , {id : $scope.employee_id})

              .then(function (employee) {

                  $scope.employee_id = employee.employee.id;

                  $scope.find_seller = employee.name;

                  $scope.autocompleteSeller = false;

                  $scope.employee = employee;

              });

      }


      $scope.all_sale_payments = true;

      $scope.getTotalCommission = function()
      {

        if($scope.commission_type == 'total')
        {
          $scope.total_commission = $scope.sale.total
        }
        else
        {
          var total_commission = 0;

          angular.forEach($scope.sale.sale_payments, function(value, key) {

              if(value.in_commission)
              {

                total_commission += parseFloat(value.subtotal);

              }

          });

          $scope.total_commission = total_commission;
        }

      }

      $scope.getTotals = function()
      {

        $scope.getTotalCommission();

        $scope.getTotal();

      }
      $scope.getTotal = function()
      {

        var total = 0;

        if(!isNaN($scope.percent) && !isNaN($scope.total_commission))
        {

          total = ($scope.total_commission * $scope.percent ) / 100;

        }

        $scope.total = total;

      }

      $scope.getCommissionTypeInit = function()
      {

        var commission_type;

        if($scope.sale.sale_type == 'contado')
        {
          commission_type = 'total';

        }else{

          commission_type = 'sale_payments';

        }

        return commission_type;

      }

      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

      UsersService.API( 'all').then(function (data) {

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

      $scope.error_percent = false;

      $scope.error_total_commission = false;

      $scope.commissions = [];

      $scope.addCommissions = function()
      {
        var error = false;

        $scope.error_percent = false;

        $scope.error_total_commission = false;

        $scope.error_employee = false;

        $scope.error_date = false;

        if(!$scope.date)
        {
          error = true;
          $scope.error_date = 'Debe asignar una fecha';

        }

        if(isNaN($scope.percent))
        {
          error = true;
          $scope.error_percent = 'El porcentaje de comisión debe ser un número';

        }else
        {
          if($scope.percent === 0)
          {
            error = true;
            $scope.error_percent = 'El porcentaje de comisión debe ser mayor a cero';
          }
        }

        if(!error)
        {

          angular.forEach($scope.sales , function(sale){

            var total_commission = ($scope.percent * sale.total ) / 100;
            console.log($filter('date')($scope.date,'yyyy-MM-dd HH:mm:ss'));
            var commission = {

              sale_id : sale.id,

              employee_id : ( ($scope.self_seller) ? sale.employee_id : $scope.employee_id  ),

              employee_name : ( ($scope.self_seller) ? sale.employee_name : $scope.find_seller  ),

              percent : $scope.percent,

              date : $filter('date')($scope.date,'yyyy-MM-dd HH:mm:ss'),

              status_pay : $scope.status_pay,

              total_commission : total_commission,

              total : sale.total,

              type : 'total'

            }

            $scope.commissions.push(commission);

          })

          $scope.employee_id = '';

          $scope.find_seller = '';

          $scope.percent = 0;

          $scope.total = 0;

        }



      }

      $scope.deleteCommission = function(id)
      {

        $scope.commissions.splice(id, 1);

      }

      $scope.checkValuePreOrOld = function (pre , old , def , date)
      {
        var date = date || false;

          if(!def)
              def = '';

          var value = def;

          if(pre)
              value = pre;

          if(old)
              value = old;

          if(date)
          {
            value = new Date(value)
          }

          return value;


      }

    }])

    .controller('EditController', [ '$scope' , '$q' ,'SalesService' , 'UsersService' , 'CommissionsService' , function ($scope , $q ,SalesService , UsersService , CommissionsService) {

      $scope.init = function(id)
      {

        CommissionsService.API('findById' , {id : id}).then(function (commission) {

          $scope.commission = commission;

          $scope.sale = commission.sale;

          $scope.commission_type = $scope.commission.type;

          $scope.total = $scope.commission.total;

          $scope.percent = $scope.commission.percent;

          $scope.total_commission = $scope.commission.total_commission;

          $scope.employee_id = $scope.commission.employee_id;

          $scope.find_seller = $scope.commission.employee.user.name;

        }).then(function(){


          angular.forEach($scope.sale.sale_payments, function(value, key) {

            $scope.search_in_commission(value , $scope.commission.sale_payments)

            .then(function(in_commission){

                $scope.sale.sale_payments[key].in_commission = in_commission;

            });

          });

        });
      }

      $scope.search_in_commission = function(value , sale_payments)
      {

        var deferred = $q.defer();

        sale_payments.filter(function (sale_payment) {

          if(sale_payment.id == value.id){

            data = true;

            deferred.resolve(data);

          }

        })

        return deferred.promise;

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

      $scope.all_sale_payments = true;

      $scope.getTotalCommission = function()
      {

        if($scope.commission_type == 'total')
        {
          $scope.total_commission = $scope.sale.total
        }
        else
        {
          var total_commission = 0;

          angular.forEach($scope.sale.sale_payments, function(value, key) {

              if(value.in_commission)
              {

                total_commission += parseFloat(value.subtotal);

              }

          });

          $scope.total_commission = total_commission;
        }

      }

      $scope.getTotals = function()
      { console.log('fd')

        $scope.getTotalCommission();

        $scope.getTotal();

      }
      $scope.getTotal = function()
      { console.log($scope.total_commission);

        var total = 0;

        if(!isNaN($scope.percent) && !isNaN($scope.total_commission))
        {

          total = ($scope.total_commission * $scope.percent ) / 100;

        }

        $scope.total = total;

      }

      $scope.getCommissionTypeInit = function()
      {

        var commission_type;

        if($scope.sale.sale_type == 'contado')
        {
          commission_type = 'total';

        }else{

          commission_type = 'sale_payments';

        }

        return commission_type;

      }

      $scope.find_seller = '';

      $scope.autocompleteSeller = false;

      $scope.sellers = {};

        UsersService.API( 'all').then(function (data) {

            $scope.sellersAll = data;

      });

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

      $scope.error_percent = false;

      $scope.error_total_commission = false;

      $scope.commissions = [];

      $scope.addCommission = function()
      {
        var error = false;

        $scope.error_percent = false;

        $scope.error_total_commission = false;

        $scope.error_employee = false;

        if(isNaN($scope.percent))
        {
          error = true;
          $scope.error_percent = 'El porcentaje de comisión debe ser un número';

        }else
        {
          if($scope.percent === 0)
          {
            error = true;
            $scope.error_percent = 'El porcentaje de comisión debe ser mayor a cero';
          }
        }

        if($scope.total_commission === 0)
        {

          error = true;
          $scope.error_total_commission = 'La cantidad total sobre la que se aplicara la comisión debe ser mayor a cero';

        }

        /*if(!$scope.employee_id || !$scope.find_seller)
        {

          error = true;
          $scope.error_employee = 'Debes seleccionar un vendedor';
        }*/

        if(!error)
        {

          var commission = {

            employee_id : $scope.employee_id,

            employee_name : $scope.find_seller,

            percent : $scope.percent,

            total_commission : $scope.total_commission,

            total : $scope.total,

            type : $scope.commission_type,

            SalePayments : {}

          }

          if(commission.type == 'sale_payments')
          {

            angular.forEach($scope.sale.sale_payments, function(value, key) {

              if(value.in_commission)
              {

                commission.SalePayments[value.id] = true;

              }

            });

          }

          $scope.commissions.push(commission);

          $scope.employee_id = '';

          $scope.find_seller = '';

          $scope.percent = 0;

          $scope.total = 0;

        }



      }

      $scope.deleteCommission = function(id)
      {

        $scope.commissions.splice(id, 1);

      }

      $scope.checkValuePreOrOld = function (pre , old , def , date)
      {
        var date = date || false;

          if(!def)
              def = '';

          var value = def;

          if(pre)
              value = pre;

          if(old)
              value = old;

          if(date)
          {
            value = new Date(value)
          }

          return value;


      }

    }])

    .controller('ShowController', [ '$scope'  , function ($scope ) {



    }]);


})();