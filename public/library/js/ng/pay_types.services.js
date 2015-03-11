(function () {

  angular.module('pay_types.services', [])

    .factory('PayTypeService', ['$http', '$q',  function ($http, $q ) {      

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/pay_types/';

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

      function add( params ) 
      {

        var deferred = $q.defer();

        var url = 'pay_types/';

       $http({
            method: 'POST',
            url: url,
            data: $.param(params),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function (data) {

          deferred.resolve(data);

        });

        return deferred.promise;

      }

      return {
        API : API,
        add : add

      };

    }]);

})();
