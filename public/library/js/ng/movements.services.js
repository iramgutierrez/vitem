(function () {

  angular.module('movements.services', [])

    .factory('MovementsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');

      function all() {
        var deferred = $q.defer();

        $http.get('API/movements')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function API( method , params)
      {

        var deferred = $q.defer();

        var url = 'API/movements/';

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

      function search2( movementsAll ,  initDate , endDate)
      {

        var movements = movementsAll;

        if(initDate && endDate)
          movements = findByRangeDate(initDate , endDate , products);


          return movements;
      }

      function findByRangeDate(initDate , endDate , movementsAll)
      {

        var movements;

        if(initDate == '' || initDate == '')
          movements = movementsAll;
        else
        {
          movements = movementsAll.filter(function ( movement )
          {

              if(movement.hasOwnProperty('date')){

                return movement.date >= initDate && movement.sale_date <= date;

              }

          });

        }

        return movements;
      }

      return {
        all: all ,
        search2 : search2,
        API : API

      };

    }]);

})();
