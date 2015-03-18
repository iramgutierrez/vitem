(function () {

  var app = angular.module('dashboard', [
    'ui.date',
    'dashboard.controllers',
    'dashboard.services'
  ]);

  app.filter('capitalize', function() {
    return function(input) {
      return input.charAt(0).toUpperCase() + input.slice(1);
    }
  })

  app.filter('destination_types', function () {

      return function (input) {
        var type;

        if(input == 1)
        {
          type = 'Código postal';

        }else if(input == 2)
        {
          type = 'Colonia';

        }else if(input == 3)
        {
          type = 'Delegación o munucipio';

        }else if(input == 4)
        {
          type = 'Estado';

        }

        return type;

      };
    });

  app.run([ '$q' , '$http' ,  '$rootScope' , function( $q , $http , $rootScope){

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

                 console.log($rootScope.auth_permissions);

             })

     }

 }])

})();
