(function () {

  angular.module('products.services', [])

    .factory('ProductsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function all() {

        var deferred = $q.defer();

        $http.get('API/products')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/products/';

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

      function findById(id)
      {
        var deferred = $q.defer();

        $http.get('API/products/findById?id='+id)
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function search(find, productsAll , productsExcluded , supplier_id , store_id )
      { 

        find = normalize(find);

        var products;
        
        if(productsExcluded && productsExcluded.length)
          productsAll = excludeProducts(productsExcluded , productsAll)

        if(supplier_id)
          productsAll = findBySupplierId(supplier_id , productsAll);

        /*if(store_id)
          productsAll = getStockPerStore(store_id , productsAll);*/

        if(find == '')
            products =  productsAll;
          else
          {   
            products = productsAll.filter(function (product) {
              return normalize(product.id.toString()).indexOf(find) != -1 
                || normalize(product.name).indexOf(find) != -1
                || normalize(product.key).indexOf(find) != -1
                || normalize(product.model).indexOf(find) != -1;
            });
          }

          return products;
      }

      function getStockPerStore(store_id , productsAll)
      { 

        var products;

        if(store_id == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product) 
          {

            var quantity = false;

            if(product.hasOwnProperty('stores'))
            {

              angular.forEach(product.stores, function(store, key) {

                  

                if(store.id == store_id)
                {

                  console.log(store.pivot.quantity);
                  
                  if(store.pivot.quantity > 0)
                  {

                    quantity = true

                  }

                }

              });

            }

            return quantity;

          }); 

        }        

        return products;

      }

      function findByStatus(status, productsAll) 
      {

        var products;

        if(status == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product) 
          {
            return product.status ==  status;
          }); 
        }        

        return products;

      }



        function findBySupplierId(supplier_id, productsAll)
        {

          var products;

          if(supplier_id == '')
            products =  productsAll;
          else
          {
            products = productsAll.filter(function (product)
            {
              return product.supplier_id ==  supplier_id;
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
        API : API , 
        findById : findById,
        search : search,

      };

    }]);

})();
