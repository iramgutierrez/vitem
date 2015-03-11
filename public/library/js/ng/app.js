(function () {

  var app = angular.module('users', [
      'ui.date',
      'users.controllers',
      'users.services',
      'sales.services',
      'users.filters',
      'commissions.filters',
      'users.directives'
  ]);

  app.run([ '$q' , '$http' ,  '$rootScope' , function( $q , $http , $rootScope){

    $rootScope.check = function(entity_slug , action_slug , role_slug )
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

  }])

})();
