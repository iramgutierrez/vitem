(function () {

  var app = angular.module('sales', [
    'ui.date',
    'sales.controllers',
    'sales.services',
    'users.services',
    'clients.services',
    'products.services',
    'packages.services',
    'destinations.services',
    'users.filters',
    'commissions.filters',
    'destinations.filters',
    'products.filters',
    'suppliers.services',
    'colors.services',
    'directives',
  ]).run([ '$q' , '$http' ,  '$rootScope' , function( $q , $http , $rootScope){

    $rootScope.user_permissions = [];

    $rootScope.auth_permissions = [];

    $rootScope.getPermissionsByRoleId = function(role_id)
    {
      var deferred = $q.defer();

      var url = 'API/permissions/';

      url += 'getByRoleId' + '?';

      url += 'role_id=' + role_id;

      $http.get(url)
          .success(function (data) {

            deferred.resolve(data);

          });

      return deferred.promise;

    }

    $rootScope.generateUserPermissions = function(role_id)
    {

      $rootScope.getPermissionsByRoleId(role_id)

          .then(function (data) {

            angular.forEach(data, function(permission, key) {

              var action = permission.action.slug;

              var entity = permission.entity.slug;

              if(!$rootScope.user_permissions.hasOwnProperty(action))
              {

                $rootScope.user_permissions[action] = [];

              }

              $rootScope.user_permissions[action][entity] = true;


            })

          })

    }

    $rootScope.generateAuthPermissions = function(role_id)
    {

      $rootScope.getPermissionsByRoleId(role_id)

          .then(function (data) {

            angular.forEach(data, function(permission, key) {

              var action = permission.action.slug;

              var entity = permission.entity.slug;

              if(!$rootScope.auth_permissions.hasOwnProperty(action))
              {

                $rootScope.auth_permissions[action] = [];

              }

              $rootScope.auth_permissions[action][entity] = true;


            })

          })

    }

    $rootScope.productsSelected = [];

    $rootScope.find_client = '';

    $rootScope.autocompleteClient = false;

    $rootScope.addClient = function(client)
    {

      $rootScope.client_id = client.id;

      $rootScope.find_client = client.name;

      $rootScope.autocompleteClient = false;

      return false;
    }


  }]);

})();
