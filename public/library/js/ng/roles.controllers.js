(function () {

  angular.module('roles.controllers', [])

    .controller('RolesController', ['$scope', '$filter' , 'RolesService', function ($scope ,  $filter , RolesService) {
        
        $scope.find = '';   
        $scope.type = ''; 
        $scope.status = ''; 
        $scope.sort = 'id';
        $scope.reverse = false;
        $scope.pagination = true;
        $scope.page = 1;
        $scope.perPage = 10;
        $scope.optionsPerPage = [ 5, 10, 15 , 20 , 30, 40, 50, 100 ];
        $scope.viewGrid = 'list';

        RolesService.all().then(function (data) {

          $scope.rolesAll = data;

          $scope.roles = data;

          $scope.paginate(1);          

        });

        RolesService.getEntities().then(function (data) {

          $scope.entities = data;

        });

        RolesService.getActions().then(function (data) {

          $scope.actions = data;  

        });

        $scope.checkPermission = function(permissions , entity_id , action_id)
        {          

          var permission = false;

          for (var i = 0, len = permissions.length; i < len; i++) {
           
            if(permissions[i].entity_id == entity_id && permissions[i].action_id == action_id)
            {

              permission = true;

              break;

            }

          }

          return permission;

        }

        $scope.paginate = function( p )
        {
          if($scope.pagination)
          {            

            if(p)
              $scope.page = parseInt(p);           

            $scope.pages = Math.ceil( $scope.roles.length / $scope.perPage );

            $scope.rolesP = $scope.roles.slice( ( ($scope.page -1) *  $scope.perPage ) , ($scope.page *  $scope.perPage ) );

          }
          else
          {
            $scope.rolesP = $scope.roles
          }
        }



        $scope.search = function ()
        {  

        	$scope.roles = RolesService.search($scope.find , $scope.rolesAll);

          $scope.paginate(1);

        }

        $scope.clear = function () 
        {
        	$scope.find = '';   
	        $scope.type = '';  
          $scope.status = '';  
	        $scope.sort = 'id';
	        $scope.reverse = false;
	        $scope.roles = $scope.rolesAll;
          $scope.paginate(1);
          $scope.modal = false;

        }


    }])

    .controller('FormController', ['$scope', '$filter' , 'RolesService', function ($scope ,  $filter , RolesService) {        
            

        RolesService.getEntities().then(function (data) {

          $scope.entities = data;

        });

        RolesService.getActions().then(function (data) {

          $scope.actions = data;  

        });

        $scope.visibility = false;

        $scope.checkLevel = function()
        {

            if($scope.visibility == 'self' )
            {
                $scope.current_level = 1;
            }
            else if($scope.visibility == 'all' )
            {
                $scope.current_level = 3;
            }
            else
                $scope.current_level = 1;

        }

        $scope.changeCurrentLevel = function(level)
        {

            $scope.current_level = level;


        }

    }])

    .controller('EditController', ['$scope', '$filter' , 'RolesService', function ($scope ,  $filter , RolesService) {
        
        $scope.permissions = [];

        $scope.getRole = function(id)
        {          

          RolesService.getById(id).then(function (data) {

            $scope.role = data;  

            if($scope.role.hasOwnProperty('permission'))
            {

              var permissions = $scope.role.permission;

              var permissionTmp = [];

              angular.forEach(permissions, function(permission, key) {

                if(!$scope.permissions.hasOwnProperty(permission.action_id))
                {

                  $scope.permissions[permission.action_id] = [];

                }

                $scope.permissions[permission.action_id][permission.entity_id] = true;
              
              });

            }

          });

        }        

        RolesService.getEntities().then(function (data) {

          $scope.entities = data;

        });

        RolesService.getActions().then(function (data) {

          $scope.actions = data;  

        });

    }])

    .controller('ShowController', ['$scope', '$filter' , 'RolesService', function ($scope ,  $filter , RolesService) {
        
        $scope.permissions = [];

        $scope.tab = 'permisos';

        $scope.getRole = function(id)
        {          

          RolesService.getById(id).then(function (data) {

            $scope.role = data;  

            console.log($scope.role);

            if($scope.role.hasOwnProperty('permission'))
            {

              var permissions = $scope.role.permission;

              var permissionTmp = [];

              angular.forEach(permissions, function(permission, key) {

                if(!$scope.permissions.hasOwnProperty(permission.action_id))
                {

                  $scope.permissions[permission.action_id] = [];

                }

                $scope.permissions[permission.action_id][permission.entity_id] = true;
              
              });

            }

          });

        }        

        RolesService.getEntities().then(function (data) {

          $scope.entities = data;

        });

        RolesService.getActions().then(function (data) {

          $scope.actions = data;  

        });

        $scope.checkPermission = function(permissions , entity_id , action_id)
        {          

          if(!permissions)
            permissions = [];

          var permission = false;

          for (var i = 0, len = permissions.length; i < len; i++) {
           
            if(permissions[i].entity_id == entity_id && permissions[i].action_id == action_id)
            {

              permission = true;

              break;

            }

          }

          return permission;

        }

    }])

})();
