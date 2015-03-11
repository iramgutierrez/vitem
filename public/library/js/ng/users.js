(function () {

 angular.module('users', [

    'ui.date',
    'users.controllers',
    'users.services',
    'sales.services',
    'users.filters',
    'commissions.filters',
    'users.directives'

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



 }])

})();
