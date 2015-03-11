(function () {

  angular.module('reports.controllers', [])

    .controller('SalesController', ['$scope', '$filter' , 'SalesService' , 'UsersService' , 'ClientsService' , function ($scope ,  $filter , SalesService , UsersService , ClientsService ) {
        
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
        $scope.initDate = '';
        $scope.endDate = '';

        $scope.employee_id = '';

        $scope.find_seller = '';

        $scope.autocompleteSeller = false;

        $scope.sellers = {};

        $scope.seller = {};

        UsersService.getByRoleId(1).then(function (data) {

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
              pay_type : $scope.pay_type, 
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

          console.log(data);

          /*$scope.salesAll = data;

          $scope.sales = data;

          $scope.search(true);

          $scope.paginate(); */ 

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
          
          	$scope.sales = SalesService.search2($scope.employee_id , $scope.client_id , $scope.salesAll , $scope.sale_type , $scope.pay_type, (angular.isDate($scope.initDate)) ? $scope.initDate.format('yyyy-mm-dd') : $scope.initDate , (angular.isDate($scope.endDate)) ? $scope.endDate.format('yyyy-mm-dd') : $scope.endDate);

            
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


    }])

})();