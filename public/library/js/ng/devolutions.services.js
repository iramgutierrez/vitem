(function () {

  angular.module('devolutions.services', [])

      .factory('DevolutionsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
        var normalize = $filter('normalize');

        function all() {
          var deferred = $q.defer();

          $http.get('API/devolutions')
              .success(function (data) {
                deferred.resolve(data);
              });

          return deferred.promise;
        }

        function API( method , params)
        {

          var deferred = $q.defer();

          var url = 'API/devolutions/';

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

        function getProducts(id)
        {
          var deferred = $q.defer();

          $http.get('API/devolutions/getProducts?id='+id)
              .success(function (data) {
                deferred.resolve(data);
              });

          return deferred.promise;
        }

        function search(find, devolutionsAll , operatorDevolutionDate , devolutionDate)
        {

          find = normalize(find);

          var devolutions;

          if(operatorDevolutionDate && devolutionDate)
            devolutionsAll = findByDevolutionDate(operatorDevolutionDate , devolutionDate , devolutionsAll);


          if(find == '')
            devolutions =  devolutionsAll;
          else
          {
            devolutions = devolutionsAll.filter(function (devolution) {
              return normalize(devolution.id.toString()).indexOf(find) != -1
                  || normalize(devolution.supplier.name).indexOf(find) != -1
                  || normalize(devolution.supplier.email).indexOf(find) != -1;
            });
          }

          return devolutions;
        }

        function findByDevolutionDate(operator , devolutionDate , devolutionsAll)
        {

          var devolutions;

          if(operator == '' || devolutionDate == '')
            devolutions = devolutionsAll;
          else
          {
            devolutions = devolutionsAll.filter(function ( devolution )
            {


              if(devolution.hasOwnProperty('devolution_date')){

                if(angular.isDate(devolutionDate))
                {
                  devolutionDate = $filter('date')(devolutionDate ,'yyyy-MM-dd');
                }

                switch(operator)
                {
                  case '<':
                    return  devolution.devolution_date  < devolutionDate;
                    break;
                  case '==':
                    return devolution.devolution_date == devolutionDate;
                    break;
                  case '>':
                    return devolution.devolution_date > devolutionDate;
                    break;

                }


              }

              return false;

            });
          }

          return devolutions;
        }

        function findByRangeDate(initDate , endDate , productsAll)
        {

          var products;

          if(initDate == '' || initDate == '')
            products = productsAll;
          else
          {
            products = productsAll.filter(function ( product )
            {

              if(product.hasOwnProperty('sale_date')){

                return product.sale_date >= initDate && product.sale_date <= endDate;

              }

            });

          }

          return products;
        }

        function excludeProducts(productsExcluded , productsAll)
        {



          for( s = 0; s <= productsExcluded.length -1; s++) {

            for( p = 0; p <= productsAll.length -1; p++) {

              if(productsExcluded[s].id === productsAll[p].id)
              {

                productsAll.splice(p, 1);

              }

            }

          }


          return productsAll;

        }

        return {
          all: all ,
          search : search,
          getProducts : getProducts,
          API : API

        };

      }]);

})();
