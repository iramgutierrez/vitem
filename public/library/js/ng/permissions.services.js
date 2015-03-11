(function () {

  angular.module('permissions.services', [])

    .factory('PermissionsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {

        function checkPermissionBySlug(entity_slug,action_slug,role_slug)
        {

          var deferred = $q.defer();

          var url = 'API/permissions/';

          url += 'checkBySlug' + '?';

          url += 'entity_slug=' + entity_slug + "&";

          url += 'action_slug=' + action_slug+ "&";

          url += 'role_slug=' + role_slug;

          $http.get(url)
              .success(function (data) {

                deferred.resolve(data);

              });

          return deferred.promise;

        }

      return {
        checkPermissionBySlug: checkPermissionBySlug


      };

    }]);

})();
