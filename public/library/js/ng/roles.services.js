(function () {

  angular.module('roles.services', [])

    .factory('RolesService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {

      var normalize = $filter('normalize');      

      function all() {
        var deferred = $q.defer();

        $http.get('API/roles')

          .success(function (data) {

            deferred.resolve(data);

          });

        return deferred.promise;
      }     

      function getById(id) {

        var deferred = $q.defer();

        $http.get('API/roles/getById?id='+id)

          .success(function (data) {

            deferred.resolve(data);

          });

        return deferred.promise;
      }  

      function getEntities() {
        var deferred = $q.defer();

        $http.get('API/entities')

          .success(function (data) {

            deferred.resolve(data);

          });

        return deferred.promise;
      }    

      function getActions() {

        var deferred = $q.defer();

        $http.get('API/actions')

          .success(function (data) {

            deferred.resolve(data);

          });

        return deferred.promise;
      }

      function search(find, rolesAll ) 
      {

        find = normalize(find);    

        var roles;

        if(find == '')
            roles =  rolesAll;
          else
          {
            roles = rolesAll.filter(function (role) {

              return normalize(role.id.toString()).indexOf(find) != -1 

                || normalize(role.slug).indexOf(find) != -1;

            });

          }

          return roles;
      }

      return {
        all: all ,
        search : search,
        getEntities : getEntities,
        getActions : getActions,
        getById : getById

      };

    }]);

})();
