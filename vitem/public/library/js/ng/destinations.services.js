(function () {

  angular.module('destinations.services', [])

    .factory('DestinationsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function all() {
        var deferred = $q.defer();

        $http.get('API/destinations')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/destinations/';

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

      function search(find, destinationsAll , type) 
      { 

        find = normalize(find);

        var destinations;
       
        if(type) 
          destinationsAll = findByType(type , destinationsAll);
        
        if(find == '')
            destinations =  destinationsAll;
          else
          {   
            destinations = destinationsAll.filter(function (destination) {
              return normalize(destination.zip_code).indexOf(find) != -1
                || normalize(destination.colony).indexOf(find) != -1 
                || normalize(destination.town).indexOf(find) != -1
                || normalize(destination.state).indexOf(find) != -1;
            });
          }   

          return destinations;
      }

      function findByType(type, destinationsAll) 
      {

        var destinations;

        if(type == '')
          destinations =  destinationsAll;
        else
        {
          destinations = destinationsAll.filter(function (destination) 
          {
            return destination.type ==  type;
          }); 
        }        

        return destinations;

      }

      return {
        all: all ,
        search : search,
        API : API

      };

    }]);

})();
