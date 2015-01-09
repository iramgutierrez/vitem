(function () {

  angular.module('users.controllers', [])

    .controller('UsersController', ['$scope', '$filter' , 'UsersService', function ($scope ,  $filter , UsersService) {
        
        $scope.find = '';   
        $scope.type = ''; 
        $scope.status = ''; 
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.operatorEntryDate = '';
        $scope.entryDate = '';
        $scope.operatorSalary = '';
        $scope.salary = '';
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';
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

        UsersService.all().then(function (data) {

          $scope.usersAll = data;

          $scope.users = data;

          $scope.paginate(1);          

        });

        UsersService.getByRoleId(1).then(function (data) {

          console.log(data)         

        });

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.users.length / $scope.perPage );

            $scope.usersP = $scope.users.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.usersP = $scope.users
          }
        }



        $scope.search = function ()
        {     

        	$scope.salary = $filter('decimal')($scope.salary);

        	$scope.users = UsersService.search($scope.find , $scope.usersAll , $scope.type , $scope.status , $scope.operatorEntryDate , $scope.entryDate , $scope.operatorSalary , $scope.salary );

          $scope.paginate(1);

        }

        $scope.clear = function () 
        {
        	$scope.find = '';   
	        $scope.type = '';  
          $scope.status = '';  
	        $scope.sort = 'id';
	        $scope.reverse = false;
	        $scope.operatorSalary = '';
	        $scope.salary = '';
          $scope.operatorEntryDate = '';
          $scope.entryDate = '';
	        $scope.users = $scope.usersAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', [ '$scope' , 'UsersService' , function ($scope , UsersService) {

      $scope.status = 'Inactivo';      
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

        UsersService.getByRoleId(1).then(function (data) {

          console.log(data)         

        });

    }])

})();
