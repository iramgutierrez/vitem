(function () {

  angular.module('compare_drivers', [
    'directives',
    'users.services',
    'users.filters'
  ])

  .controller('Controller' , [ '$scope' , '$filter' ,  'UsersService', function($scope , $filter ,UsersService){

        $scope.drivers = {};

        UsersService.API('getDrivers').then(function (data) {

            $scope.driversAll = data;

        });

        $scope.find_driver_1 = '';

        $scope.autocompleteDriver_1 = false;

        $scope.driver_1 = {};

        $scope.searchDriver1 = function ()
        { 
          
            if($scope.find_driver_1.length != '')
            {   
                $scope.drivers = UsersService.search($scope.find_driver_1 , $scope.driversAll , false , 1 , false , false , false , false );
                  
                $scope.autocompleteDriver_1 = true;

            }else{

                $scope.drivers = {};

                $scope.autocompleteDriver_1 = false;

            }
            

        }        

        $scope.addDriver1 = function(driver)
        {       
            $scope.employee_id_1 = driver.employee.id;

            $scope.find_driver_1 = driver.name;

            $scope.driver_1 = driver;

            $scope.autocompleteDriver_1 = false;

            return false;
        }

        $scope.blurDriver1 = function()
        {

          if($scope.find_driver_1 == '')
          {
            $scope.employee_id_1 = '';

            $scope.driver_1 = {};
          }
          else
          {
            if($scope.driver_1.hasOwnProperty('name'))
            {
              $scope.find_driver_1 = $scope.driver.name;
            }
            else
            {
              $scope.find_driver_1 = '';
            }
          }

          $scope.hideItems();

        }

        $scope.find_driver_2 = '';

        $scope.autocompleteDriver_2 = false;

        $scope.driver_2 = {};

        $scope.searchDriver2 = function ()
        { 
          
            if($scope.find_driver_2.length != '')
            {   
                $scope.drivers = UsersService.search($scope.find_driver_2 , $scope.driversAll , false , 1 , false , false , false , false );
                
                $scope.autocompleteDriver_2 = true;

            }else{

                $scope.drivers = {};

                $scope.autocompleteDriver_2 = false;

            }
            

        }        

        $scope.addDriver2 = function(driver)
        { 
            $scope.employee_id_2 = driver.employee.id;

            $scope.find_driver_2 = driver.name;

            $scope.driver_2 = driver;

            $scope.autocompleteDriver_2 = false;

            return false;
        }

        $scope.blurDriver2 = function()
        {

          if($scope.find_driver_2 == '')
          {
            $scope.employee_id_2 = '';

            $scope.driver_2 = {};
          }
          else
          {
            if($scope.driver_2.hasOwnProperty('name'))
            {
              $scope.find_driver_2 = $scope.driver.name;
            }
            else
            {
              $scope.find_driver_2 = '';
            }
          }

          $scope.hideItems();

        }


        $scope.hideItems = function () 
        {
            window.setTimeout(function() {

                $scope.$apply(function() {
                
                    $scope.autocompleteDriver_1 = false;
                
                    $scope.autocompleteDriver_2 = false;

                });

            }, 300);
            
        }

        $scope.driversCompare = [];

        $scope.getCompareDrivers = function()
        {

            UsersService.API('CompareDrivers',
                                {
                                    'driver_1' : $scope.employee_id_1 ,
                                    'driver_2' : $scope.employee_id_2
                                }
            )
            .then(function(compare) {

               $scope.driversCompare = compare;

               $scope.getFields();
            })

        }

        $scope.checkInRange = function(entity , sale_field)
        { 

            var inRange = true;

            if(angular.isDate($scope.init_date)){
                init_date = $scope.init_date
            }
            else
            {
                init_date = new Date($scope.init_date);
            }


            if(angular.isDate($scope.end_date)){
                end_date = $scope.end_date;
            }
            else
            {
                end_date = new Date($scope.end_date);
            }

            var date = new Date(entity[sale_field]);

            inRange = (date.format('yyyy-mm-dd' , true) >= init_date.format('yyyy-mm-dd' , true) ) && (date.format('yyyy-mm-dd' , true) <= end_date.format('yyyy-mm-dd' , true) );

            return inRange;

        }

        $scope.checkInStatus = function(entity , sale_field , status)
        { 

            var inStatus = true;

            var today = new Date();

            var date = new Date(entity[sale_field]);

            switch(status)
            {
                case 'past':
                    inStatus = (date.format('yyyy-mm-dd' , true) < today.format('yyyy-mm-dd' , true) );
                    break;
                case 'today':
                    inStatus = (date.format('yyyy-mm-dd' , true) == today.format('yyyy-mm-dd' , true) );
                    break;
                case 'upcoming':
                    inStatus = (date.format('yyyy-mm-dd' , true) > today.format('yyyy-mm-dd' , true) );
                    break;
                default:
                    inStatus = (date.format('yyyy-mm-dd') < today.format('yyyy-mm-dd') );
                    break;  

            }          

            return inStatus;

        }

        $scope.getSalesCount = function(sellers , type)
        {
            var sales = [];

            angular.forEach(sellers, function(seller, key) {

                var salesBySeller = 0;

                angular.forEach(seller.sales , function (sale , key) {

                    if(sale.sale_type == type )
                    {

                        var inRange =  $scope.checkInRange(sale , 'sale_date');

                        if(inRange)
                        {
                            salesBySeller++;
                        }                   
                        
                    }

                });

                sales.push({ count : salesBySeller } );

            });

            return sales;
        }



        $scope.getSalePaymentsCount = function(sellers , type)
        {
            var salePayments = [];

            angular.forEach(sellers, function(seller, key) {

                var salePaymentsBySeller = 0;

                angular.forEach(seller.sale_payments , function (sale_payment , key) {

                        var inRange =  $scope.checkInRange(sale_payment , 'created_at');

                        if(inRange)
                        {
                            if(type == 'count')
                            {
                                salePaymentsBySeller++;
                            }
                            else if(type == 'amount')
                            {
                                salePaymentsBySeller = parseFloat(salePaymentsBySeller) + parseFloat(sale_payment.total);
                            }
                        }  

                });

                if(type == 'amount')
                {
                    salePaymentsBySeller = $filter('currency')(salePaymentsBySeller);
                }

                salePayments.push({ count : salePaymentsBySeller } );

            });

            return salePayments;
        }

        $scope.getEntryDate = function(sellers)
        {
            var entry_dates = [];

            angular.forEach(sellers, function(seller, key) {

                var entryDate = '';

                entryDate = seller.entry_date;

                entry_dates.push({ count : entryDate } );

            });

            return entry_dates;
        }

        $scope.getSalary = function(sellers)
        {
            var salaries = [];

            angular.forEach(sellers, function(seller, key) {

                var salary = '';

                salary = seller.salary;

                salaries.push({ count : $filter('currency')(salary) } );

            });

            return salaries;
        }

        $scope.getCashSalesAmountCount = function(sellers)
        {
            var sales = [];

            angular.forEach(sellers, function(seller, key) {

                var salesBySeller = 0;

                angular.forEach(seller.sales , function (sale , key) {

                    //if(sale.sale_type == 'contado' )
                    //{

                        var inRange =  $scope.checkInRange(sale , 'sale_date');

                        if(inRange)
                        { 
                            salesBySeller = parseFloat(salesBySeller) + parseFloat(sale.total);
                        }

                    //}

                });

                sales.push({ count : $filter('currency')(salesBySeller) } );

            });

            return sales;
        }

        $scope.getDeliveriesCount = function(drivers , type , status)
        {

            var deliveries = [];

            angular.forEach(drivers, function(driver, key) {

                var deliveriesByDriver = 0;

                angular.forEach(driver.deliveries , function (delivery , key) {

                    var inRange =  $scope.checkInRange(delivery , ['delivery_date']);

                    if(inRange)
                    {
                        var inStatus = $scope.checkInStatus(delivery , ['delivery_date'] , status);

                        if(inStatus)
                        {

                            if(type == 'count')
                            {
                                deliveriesByDriver++;
                            }
                            else if(type == 'amount')
                            {
                                deliveriesByDriver = parseFloat(deliveriesByDriver) + parseFloat(delivery.total);
                            }
                            
                        }
                    }

                });

                if(type == 'amount')
                {
                    deliveriesByDriver = $filter('currency')(deliveriesByDriver);
                }


                deliveries.push({ count : deliveriesByDriver } );

            });

            return deliveries;
        }

        $scope.getCommissionsCount = function(sellers , type)
        {

            var commissions = [];

            angular.forEach(sellers, function(seller, key) {

                var commissionsBySeller = 0;

                angular.forEach(seller.commissions , function (commission , key) {

                    var inRange =  $scope.checkInRange(commission , ['created_at']);

                    if(inRange)
                    {
                        if(type == 'count')
                        {
                            commissionsBySeller++;
                        }
                        else if(type == 'amount')
                        {
                            commissionsBySeller = parseFloat(commissionsBySeller) + parseFloat(commission.total);
                        }
                    }

                });

                if(type == 'amount')
                {
                    commissionsBySeller = $filter('currency')(commissionsBySeller);
                }


                commissions.push({ count : commissionsBySeller } );

            });

            return commissions;
        }

        $scope.getExpensesCount = function(sellers)
        {

            var expenses = [];

            angular.forEach(sellers, function(seller, key) {

                var expensesBySeller = 0;

                angular.forEach(seller.expenses , function (expense , key) {

                    var inRange =  $scope.checkInRange(expense , ['date']);

                    if(inRange)
                    {
                        expensesBySeller++;
                    }

                });

                expenses.push({ count : expensesBySeller } );

            });

            return expenses;
        }

        $scope.getExpensesAmountCount = function(sellers)
        {

            var expenses = [];

            angular.forEach(sellers, function(seller, key) {

                var expensesBySeller = 0;

                angular.forEach(seller.expenses , function (expense , key) {

                    var inRange =  $scope.checkInRange(expense , ['date']);

                    if(inRange)
                    {
                        expensesBySeller += expense.quantity;
                    }

                });

                expenses.push({ count : $filter('currency')(expensesBySeller) } );

            });

            return expenses;
        }


        $scope.fields = [];

        $scope.getFields = function()
        {

            $scope.fields = [
                {
                    label : 'Fecha de ingreso' ,

                    data : $scope.getEntryDate($scope.driversCompare)
                },
                {
                    label : 'Salario' ,

                    data : $scope.getSalary($scope.driversCompare)
                },
                {
                    label : 'Entregas realizadas' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'count' , 'past')
                },
                {
                    label : 'Ingresos por entregas realizadas' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'amount' , 'past')
                },
                {
                    label : 'Entregas para hoy' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'count' , 'today')
                },
                {
                    label : 'Ingresos por entregas para hoy' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'amount' , 'today')
                },
                {
                    label : 'Próximas entregas' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'count' , 'upcoming')
                },
                {
                    label : 'Ingresos por próximas entregas' ,

                    data : $scope.getDeliveriesCount($scope.driversCompare , 'amount' , 'upcoming')
                },
                {
                    label : 'Comisiones pagadas' ,

                    data : $scope.getCommissionsCount($scope.driversCompare , 'count')
                },
                {
                    label : 'Monto total por comisiones pagadas' ,

                    data : $scope.getCommissionsCount($scope.driversCompare , 'amount')
                },
                {
                    label : 'Gastos asignados' ,

                    data : $scope.getExpensesCount($scope.driversCompare)
                },
                {
                    label : 'Monto total de gastos asignados' ,

                    data : $scope.getExpensesAmountCount($scope.driversCompare)
                }

            ]; 

        }

        



  }]);

})();
