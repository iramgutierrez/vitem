(function () {

  angular.module('dashboard.services', [])

    .factory('GraphService', ['$http', '$q' , function ($http, $q ) {

      function API( controller , method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/';

        url += controller + '/';

        url += method + '?';

        var count = 0;

        angular.forEach( params , function(value, key) {

          url += key + '=' + value;

          count++;

          if(count < Object.keys(params).length)
          {
            url += '&';
          }

        });

        $http.get(url)
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;

      }

      return {
        API : API
      };

    }]);

})();
