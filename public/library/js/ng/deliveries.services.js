(function () {

  angular.module('deliveries.services', [])

    .factory('DeliveriesService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');

      function all() {
        var deferred = $q.defer();

        $http.get('API/deliveries')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }  


      function search(find, deliveriesAll ) 
      { 

        find = normalize(find);

        var deliveries;
        
        if(find == '')
            deliveries =  deliveriesAll;
          else
          {   
            deliveries = deliveriesAll.filter(function (delivery) {
              return normalize(delivery.id).indexOf(find) != -1
                || normalize(delivery.sale.sheet).indexOf(find) != -1 
                || normalize(delivery.employee.user.name).indexOf(find) != -1;
            });
          }   

          return deliveries;
      }    

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/deliveries/';

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
        
        API : API ,
        all : all ,
        search : search

      };

    }]);

})();
