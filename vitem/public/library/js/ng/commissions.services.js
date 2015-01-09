(function () {

  angular.module('commissions.services', [])

    .factory('CommissionsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/commissions/';

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
