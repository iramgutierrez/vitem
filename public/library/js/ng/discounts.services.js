(function () {

  angular.module('discounts.services', [])

    .factory('DiscountsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');

      function all() {
        var deferred = $q.defer();

        $http.get('API/discounts')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }  


      function search(find, discountsAll ) 
      { 

        find = normalize(find);

        var discounts;
        
        if(find == '')
            discounts =  discountsAll;
          else
          {   
            discounts = discountsAll.filter(function (discount) {
              return normalize(discount.id).indexOf(find) != -1
                || normalize(discount.sale.sheet).indexOf(find) != -1 
                || normalize(discount.employee.user.name).indexOf(find) != -1;
            });
          }   

          return discounts;
      }    

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/discounts/';

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
