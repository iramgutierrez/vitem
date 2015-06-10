(function () {

  angular.module('stores.services', [])

      .factory('StoresService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
        
        var normalize = $filter('normalize');

        function all() {
          var deferred = $q.defer();

          $http.get('API/stores')
              .success(function (data) {
                deferred.resolve(data);
              });

          return deferred.promise;
        }

        function API( method , params)
        {

          var deferred = $q.defer();

          var url = 'API/stores/';

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

        function search(find, storesAll)
        { 

          find = normalize(find);

          var stores;

          if(find == '')
            stores =  storesAll;
          else
          {
            stores = storesAll.filter(function (store) {
              return normalize(store.id.toString()).indexOf(find) != -1
                  || normalize(store.name).indexOf(find) != -1
                  || normalize(store.email).indexOf(find) != -1
                  || normalize(store.address).indexOf(find) != -1
                  || normalize(store.phone).indexOf(find) != -1;
            });
          }

          return stores;
        }

        return {
          all: all ,
          search : search,
          API : API

        };

      }]);

})();
