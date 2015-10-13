(function () {

  angular.module('commissions.services', [])

    .factory('CommissionsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');

      function all() {
        var deferred = $q.defer();

        $http.get('API/commissions')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

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



      function search(find, commissionsAll )
      {

        find = normalize(find);

        var commissions;

        /*if(type)
          commissionsAll = findByType(type , commissionsAll);*/

        if(find == '')
            commissions =  commissionsAll;
          else
          {
            commissions = commissionsAll.filter(function (commission) {
              return normalize(commission.id).indexOf(find) != -1
                || normalize(commission.sale.sheet).indexOf(find) != -1
                || normalize(commission.employee.user.name).indexOf(find) != -1
                || normalize(commission.status_pay).indexOf(find) != -1
                || normalize(commission.type).indexOf(find) != -1;
            });
          }

          return commissions;
      }


      function findByType(type, commissionsAll)
      {

        var commissions;

        if(type == '')
          commissions =  commissionsAll;
        else
        {
          commissions = commissionsAll.filter(function (commission)
          {
            return commission.type ==  type;
          });
        }

        return commission;

      }

      return {

        API : API,
        all : all,
        search : search

      };

    }]);

})();
