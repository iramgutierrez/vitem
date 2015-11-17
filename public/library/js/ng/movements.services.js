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

      function searchLocal( movementsAll ,  find , initDate , endDate ,storeId , type, entity_type , flow)
      {

        var movements = movementsAll;

        if(initDate || endDate)
          movements = findByRangeDate(initDate , endDate , movements);

        if(find)
        {
          movements = movementsAll.filter(function (movement)
          {
            return normalize(movement.id.toString()).indexOf(find) != -1
                || normalize(movement.user.name.toString()).indexOf(find) != -1
                || normalize(movement.entity_id.toString()).indexOf(find) != -1;

          });
        }

        if(storeId)
        {
          movements = findByStoreId(storeId , movements);
        }

        if(type)
        {
          movements = findByType(type , movements);
        }

        if(entity_type)
        {
          movements = findByEntityType(entity_type , movements);
        }

        if(flow)
        {
          movements = findByFlow(flow , movements);
        }


          return movements;
      }

      function find( find , movementsAll)
      {

        var movements;

        if(!find)
          movements =  movementsAll;
        else
        {
          movements = movementsAll.filter(function (movement)
          {
            return normalize(movement.id.toString()).indexOf(find) != -1
                || normalize(movement.user.name.toString()).indexOf(find) != -1
                || normalize(movement.entity_id.toString()).indexOf(find) != -1;

          });
        }

        return movements;

      }

      function findByRangeDate(initDate , endDate , movementsAll)
      {

        var movements;

        if(!initDate && !endDate)
          movements = movementsAll;
        else
        {
          if(endDate)
          {
            endDate = endDate+' 23:59:59';
          }


          movements = movementsAll.filter(function ( movement )
          {


              if(movement.hasOwnProperty('date')){

                if(!initDate)
                {
                  return movement.date <= endDate;
                }
                else if(!endDate)
                {
                  return movement.date >= initDate;
                }
                else
                {
                  return movement.date >= initDate && movement.date <= endDate;
                }



              }

          });

        }

        return movements;
      }

      function findByStoreId( storeId , movementsAll)
      {

        var movements;

        if(!storeId)
          movements =  movementsAll;
        else
        {
          movements = movementsAll.filter(function (movement)
          {
            return movement.store_id ==  storeId;
          });
        }

        return movements;

      }

      function findByType( type , movementsAll)
      {

        var movements;

        if(!type)
          movements =  movementsAll;
        else
        {
          movements = movementsAll.filter(function (movement)
          {
            return movement.type ==  type;
          });
        }

        return movements;

      }

      function findByEntityType( entity_type , movementsAll)
      {

        var movements;

        if(!entity_type)
          movements =  movementsAll;
        else
        {
          movements = movementsAll.filter(function (movement)
          {
            return movement.entity ==  entity_type;
          });
        }

        return movements;

      }

      function findByFlow( flow , movementsAll)
      {

        var movements;

        if(!flow)
          movements =  movementsAll;
        else
        {
          movements = movementsAll.filter(function (movement)
          {

            if(flow == 'in')
            {
              return ( movement.total >= 0);
            }
            else if(flow == 'out')
            {
              return ( movement.total < 0);
            }
            else
            {
              return true;
            }

          });
        }

        return movements;

      }

      return {
        all: all ,
        searchLocal : searchLocal,
        API : API

      };

    }]);

})();
