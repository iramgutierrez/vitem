(function () {

  angular.module('commissions.controllers', [])

    /*.controller('CommissionsController', ['$scope', '$filter' , 'SalesService' , function ($scope ,  $filter , SalesService ) {
        
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


    }])*/

    .controller('FormController', [ '$scope' , 'SalesService' , 'UsersService' , function ($scope , SalesService , UsersService) {

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

        $scope.getEmployee();

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

                  $scope.employee_id = employee.id;

                  $scope.find_seller = employee.user.name;

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

    }]) 

    .controller('ShowController', [ '$scope'  , function ($scope ) {



    }]);


})();