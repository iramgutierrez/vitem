(function () {

  var app = angular.module('deliveries', [
    'ui.date',
    'deliveries.controllers',
    'deliveries.services',
    'destinations.services',
    'destinations.filters',
    'sales.services',
    'users.services',
    'users.filters',
    'directives'
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
