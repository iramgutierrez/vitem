(function () {

  angular.module('orders.services', [])

      .factory('OrdersService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
        var normalize = $filter('normalize');

        function all() {
          var deferred = $q.defer();

          $http.get('API/orders')
              .success(function (data) {
                deferred.resolve(data);
              });

          return deferred.promise;
        }

        function API( method , params)
        {

          var deferred = $q.defer();

          var url = 'API/orders/';

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

          $http.get('API/orders/getProducts?id='+id)
              .success(function (data) {
                deferred.resolve(data);
              });

          return deferred.promise;
        }

        function search(find, ordersAll , operatorOrderDate , orderDate)
        { 

          find = normalize(find);

          var orders;          

          if(operatorOrderDate && orderDate)
            ordersAll = findByOrderDate(operatorOrderDate , orderDate , ordersAll);


          if(find == '')
            orders =  ordersAll;
          else
          {
            orders = ordersAll.filter(function (order) {
              return normalize(order.id.toString()).indexOf(find) != -1
                  || normalize(order.supplier.name).indexOf(find) != -1
                  || normalize(order.supplier.email).indexOf(find) != -1;
            });
          }

          return orders;
        }

        function findByOrderDate(operator , orderDate , ordersAll)
        { 

          var orders;

          if(operator == '' || orderDate == '')
            orders = ordersAll;
          else
          {
            orders = ordersAll.filter(function ( order )
            {


              if(order.hasOwnProperty('order_date')){

                if(angular.isDate(orderDate))
                {
                  orderDate = $filter('date')(orderDate ,'yyyy-MM-dd');
                }

                switch(operator)
                {
                  case '<':
                    return  order.order_date  < orderDate;
                    break;
                  case '==':
                    return order.order_date == orderDate;
                    break;
                  case '>':
                    return order.order_date > orderDate;
                    break;

                }


              }

              return false;

            });
          }

          return orders;
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
