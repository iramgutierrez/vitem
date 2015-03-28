(function () {

  angular.module('compare_sellers', [
    'directives',
    'users.services',
    'users.filters'
  ])

  .controller('Controller' , [ '$scope' , '$filter' ,  'UsersService', function($scope , $filter ,UsersService){

        $scope.sellers = {};

        UsersService.API('getSellers').then(function (data) {

            $scope.sellersAll = data;

        });

        $scope.find_seller_1 = '';

        $scope.autocompleteSeller_1 = false;

        $scope.seller_1 = {};

        $scope.searchSeller1 = function ()
        { 
          
            if($scope.find_seller_1.length != '')
            {   
                $scope.sellers = UsersService.search($scope.find_seller_1 , $scope.sellersAll , false , 1 , false , false , false , false );
                  
                $scope.autocompleteSeller_1 = true;

            }else{

                $scope.sellers = {};

                $scope.autocompleteSeller_1 = false;

            }
            

        }        

        $scope.addSeller1 = function(seller)
        { 

      
            $scope.employee_id_1 = seller.employee.id;

            $scope.find_seller_1 = seller.name;

            $scope.seller_1 = seller;

            $scope.autocompleteSeller_1 = false;

            return false;
        }

        $scope.blurSeller1 = function()
        {

          if($scope.find_seller_1 == '')
          {
            $scope.employee_id_1 = '';

            $scope.seller_1 = {};
          }
          else
          {
            if($scope.seller_1.hasOwnProperty('name'))
            {
              $scope.find_seller_1 = $scope.seller.name;
            }
            else
            {
              $scope.find_seller_1 = '';
            }
          }

          $scope.hideItems();

        }

        $scope.find_seller_2 = '';

        $scope.autocompleteSeller_2 = false;

        $scope.seller_2 = {};

        $scope.searchSeller2 = function ()
        { 
          
            if($scope.find_seller_2.length != '')
            {   
                $scope.sellers = UsersService.search($scope.find_seller_2 , $scope.sellersAll , false , 1 , false , false , false , false );
                
                $scope.autocompleteSeller_2 = true;

            }else{

                $scope.sellers = {};

                $scope.autocompleteSeller_2 = false;

            }
            

        }        

        $scope.addSeller2 = function(seller)
        { 

      
            $scope.employee_id_2 = seller.employee.id;

            $scope.find_seller_2 = seller.name;

            $scope.seller_2 = seller;

            $scope.autocompleteSeller_2 = false;

            return false;
        }

        $scope.blurSeller1 = function()
        {

          if($scope.find_seller_2 == '')
          {
            $scope.employee_id_2 = '';

            $scope.seller_2 = {};
          }
          else
          {
            if($scope.seller_2.hasOwnProperty('name'))
            {
              $scope.find_seller_2 = $scope.seller.name;
            }
            else
            {
              $scope.find_seller_2 = '';
            }
          }

          $scope.hideItems();

        }


        $scope.hideItems = function () 
        {
            window.setTimeout(function() {

                $scope.$apply(function() {
                
                    $scope.autocompleteSeller_1 = false;
                
                    $scope.autocompleteSeller_2 = false;

                });

            }, 300);
            
        }

        $scope.sellersCompare = [];

        $scope.getCompareSellers = function()
        {

            UsersService.API('CompareSellers',
                                {
                                    'seller_1' : $scope.employee_id_1 ,
                                    'seller_2' : $scope.employee_id_2
                                }
            )
            .then(function(compare) {

               $scope.sellersCompare = compare;

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

            inRange = (date.format('yyyy-mm-dd' , true) >= init_date.format('yyyy-mm-dd' , true)) && (date.format('yyyy-mm-dd' , true) <= end_date.format('yyyy-mm-dd' , true));

            return inRange;

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

                    data : $scope.getEntryDate($scope.sellersCompare)
                },
                {
                    label : 'Salario' ,

                    data : $scope.getSalary($scope.sellersCompare)
                },
                {
                    label : 'Ventas realizadas de contado' ,

                    data : $scope.getSalesCount($scope.sellersCompare , 'contado')
                },
                {
                    label : 'Ingresos por ventas realizadas de contado' ,

                    data : $scope.getCashSalesAmountCount($scope.sellersCompare)
                },
                {
                    label : 'Ventas realizadas a pagos' ,

                    data : $scope.getSalesCount($scope.sellersCompare , 'apartado')
                },
                {
                    label : 'Abonos recibido' ,

                    data : $scope.getSalePaymentsCount($scope.sellersCompare , 'count')
                },
                {
                    label : 'Ingresos por abonos recibidos' ,

                    data : $scope.getSalePaymentsCount($scope.sellersCompare , 'amount')
                },
                {
                    label : 'Comisiones pagadas' ,

                    data : $scope.getCommissionsCount($scope.sellersCompare , 'count')
                },
                {
                    label : 'Monto total por comisiones pagadas' ,

                    data : $scope.getCommissionsCount($scope.sellersCompare , 'amount')
                },
                {
                    label : 'Gastos asignados' ,

                    data : $scope.getExpensesCount($scope.sellersCompare)
                },
                {
                    label : 'Monto total de gastos asignados' ,

                    data : $scope.getExpensesAmountCount($scope.sellersCompare)
                }

            ]; 

            console.log($scope.fields);

        }

        



  }]);

})();
