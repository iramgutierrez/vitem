(function () {

  angular.module('dashboard.controllers', [])

    .controller('GraphController', ['$scope', '$filter' , '$window' ,  'GraphService' , function ($scope , $filter , $window , GraphService ) {
        
        $scope.getData = function()
        {

          $scope.totalByRange = {};

          var init = Math.round($scope.initDate.getTime()/1000);
          var end = Math.round( ($scope.endDate.getTime()/1000));

          GraphService.API(
            'sales' , 
            'getByRange' , 
            {
              'init' : init,
              'end' :  end,
              'showBy' : $scope.showBy,
              'showSales' : $scope.showSales,
              'showSalePayments' : $scope.showSalePayments
            }
          ).then(function (data) { 

            var max = 0;
            
            for(total in data)
            {
              if(data[total] > max)
              {
                max = data[total]
              }
            }

            $scope.max = $scope.round(max*(6/5));

            $scope.totalByRange = data;

            $scope.widthContentBars = $scope.getWidthContentBars();

            $scope.animateChart();

          });

        }

        $scope.showSales = true;

        $scope.showSalePayments = true;

        $scope.showBy = 'day';

        $scope.setDates = function(yearI , monthI , dayI , yearE , monthE , dayE )
        { 
          
          $scope.initDate = new Date(yearI, monthI-1, dayI);

          $scope.endDate = new Date(yearE, monthE-1, dayE);

          $scope.getData();  


        
        }

        

        $scope.initDate = new Date();

        $scope.endDate = new Date();

       

        $scope.round = function(number)
        {
          return Math.round(number);

        }

        $scope.getPercent = function(number)
        {

          if($scope.max > 0){

            return (parseFloat(number)*100)/$scope.max + '%';
         
          } 

          return 0;         
          
          
        }

        $scope.animateChart = function()
        {
            setTimeout(function(){              

              $(".bar").each(function () {
                  var i = $(this).find(".value").html();
                  $(this).find(".value").html("");
                  $(this).find(".value").animate({
                      height: i
                  }, 1000)
              });

              

          } , 500);

        }

        $scope.getWidthContentBars = function()
        {

          return Object.keys($scope.totalByRange).length * 85;

        }

    }])

    .controller('CountsController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {

    $scope.countUp = function(count)
    { 
        var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count4'),
        run_count = 1,
        int_speed = 2;

        var int = setInterval(function() {
            if(run_count < div_by){
                $display.text(speed * run_count);
                run_count++;
            } else if(parseFloat($display.text()) < count) {
                var curr_count = parseInt($display.text()) + 1;
                $display.text(curr_count);
            } else {
                clearInterval(int);
                $display.text($filter('currency')($scope.countBalance));
            }
        }, int_speed);        
    }

    $scope.countBalance = 0;

    GraphService.API(
      'stores' , 
      'getTotalResidue' , 
      {
             
      }
    ).then(function (data) { 

      $scope.countBalance = data;

      $scope.countUp(parseFloat($scope.countBalance));

    });

    $scope.countUp2 = function(count)
    { 
        var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count2'),
        run_count = 1,
        int_speed = 2;

        var int = setInterval(function() {
            if(run_count < div_by){
                $display.text(speed * run_count);
                run_count++;
            } else if(parseFloat($display.text()) < count) {
                var curr_count = parseInt($display.text()) + 1;
                $display.text(curr_count);
            } else {
                clearInterval(int);
                $display.text($scope.salesToday);
            }
        }, int_speed);        
    }

    $scope.salesToday = 0;

    GraphService.API(
      'sales' , 
      'getSalesToday' , 
      {
             
      }
    ).then(function (data) { 

      $scope.salesToday = data;

      $scope.countUp2(parseFloat($scope.salesToday));

    });

    $scope.countUp3 = function(count)
    { 
        var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count'),
        run_count = 1,
        int_speed = 2;

        var int = setInterval(function() {
            if(run_count < div_by){
                $display.text(speed * run_count);
                run_count++;
            } else if(parseFloat($display.text()) < count) {
                var curr_count = parseInt($display.text()) + 1;
                $display.text(curr_count);
            } else {
                clearInterval(int);
                $display.text($scope.clientsWeek);
            }
        }, int_speed);        
    }

    $scope.clientsWeek = 0;

    GraphService.API(
      'clients' , 
      'getClientsWeek' , 
      {
             
      }
    ).then(function (data) { 

      $scope.clientsWeek = data;

      $scope.countUp3(parseFloat($scope.clientsWeek));

    });

    }])

    .controller('TopSellersController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {

      $scope.sellers = {};

      $scope.type = 'total_sales';

      $scope.setDates = function(yearI , monthI , dayI , yearE , monthE , dayE )
      { 
          
        $scope.initDate = new Date(yearI, monthI-1, dayI);

        $scope.endDate = new Date(yearE, monthE-1, dayE);

        $scope.getTop();
        
      }

      $scope.getTop = function()
      {

        var init = Math.round($scope.initDate.getTime()/1000);
        var end = Math.round( ($scope.endDate.getTime()/1000));

        GraphService.API(
          'users' , 
          'getTopSellers' , 
          {
            'init' : init,
            'end' :  end,
            'limit' : 5,
            'type' : $scope.type
          }
        ).then(function (data) { 

            $scope.sellers = data;

        });

      }      

    }])  

    .controller('FinishedProductsController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {
    
      $scope.products = {};
      $scope.sort = 'stock_store';
      $scope.reverse = false;

      $scope.getProducts = function ()
      {

          GraphService.API(
            'products' , 
            'getFinishedComing' , 
            {
              limitStock : 5,
              store_id : ( $scope.store_id || 0 )
            }
          ).then(function (data) { 

              $scope.products = data;

              angular.forEach($scope.products, function(product, key) {

                var stock_store = product.stock;

                if($scope.store_id)
                {   
                  if(product.stores.hasOwnProperty(0))
                  {
                    if(product.stores[0].hasOwnProperty('pivot'))
                    {

                      stock_store = product.stores[0].pivot.quantity;

                    }

                  }

                }    

                $scope.products[key].stock_store = stock_store;      

              });

          });

      }   

    }])   

    .controller('TimelineController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {
    
      $scope.records = {};

      GraphService.API(
        'settings' , 
        'getRecords' , 
        {
          limit : 20
        }
      ).then(function (data) { 

        $scope.records = data;

      });

    }])   

    .controller('LastExpensesController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {
    
      $scope.expenses = {};

      GraphService.API(
        'expenses',
        'getExpenses' ,
        {
          limit: 10
        }
      ).then(function(data) {

        $scope.expenses = data;
      })


    }])   

    .controller('UpcomingDeliveriesController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {
    
      $scope.deliveries = {};

      GraphService.API(
        'deliveries',
        'getUpcoming' ,
        {
          limit: 10,
          date : Math.round( new Date().getTime()/1000)
        }
      ).then(function(data) {

        $scope.deliveries = data;

      })


    }])   

    .controller('PendingDeliveriesController', ['$scope', '$filter' ,  'GraphService' , function ($scope , $filter , GraphService ) {
    
      $scope.sales = {};

      GraphService.API(
        'sales',
        'getWithPendingDeliveries' ,
        {
          limit: 10,
        }
      ).then(function(data) {

        $scope.sales = data;

      })


    }])   


       
      
          

})();