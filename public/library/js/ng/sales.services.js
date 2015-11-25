(function () {

  angular.module('sales.services', [])

    .factory('SalesService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');

      function all() {
        var deferred = $q.defer();

        $http.get('API/sales')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function API( method , params)
      {

        var deferred = $q.defer();

        var url = 'API/sales/';

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

        $http.get('API/sales/getProducts?id='+id)
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function getPacks(id)
      {
        var deferred = $q.defer();

        $http.get('API/sales/getPacks?id='+id)
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function search(find, productsAll , sale_type , pay_type , operatorSaleDate , saleDate)
      {

        find = normalize(find);

        var products;

        if(sale_type)
          productsAll = findBySaleType(sale_type , productsAll);

        if(pay_type)
          productsAll = findByPayType(pay_type , productsAll);

        if(operatorSaleDate && saleDate)
          productsAll = findBySaleDate(operatorSaleDate , saleDate , productsAll);


        if(find == '')
            products =  productsAll;
          else
          {
            products = productsAll.filter(function (product) {

              return normalize(product.id.toString()).indexOf(find) != -1
                || normalize(product.sheet.toString()).indexOf(find) != -1
                || ( ( product.hasOwnProperty('employee') &&  product.employee ) ? ( product.employee.hasOwnProperty('user') &&  product.employee.user ) ? (normalize(product.employee.user.name).indexOf(find) != -1) : '' : '' )
                || ( ( product.hasOwnProperty('store') &&  product.store ) ? normalize(product.store.name).indexOf(find) != -1 : '' )
                || ( ( product.hasOwnProperty('client') &&  product.client ) ? normalize(product.client.name).indexOf(find) != -1 : '' ) ;
            });
          }

          return products;
      }

      function search2(employee_id , client_id , productsAll , sale_type , pay_type_id , initDate , endDate , percent_cleared_payment_type , percent_cleared_payment)
      {

        var products = productsAll;

        if(employee_id)
          products = findByEmployeeId(employee_id , products);

        if(client_id)
          products = findByClientId(client_id , products);

        if(sale_type)
          products = findBySaleType(sale_type , products);

        if(pay_type_id)
          products = findByPayTypeId(pay_type_id , products);

        if(initDate && endDate)
          products = findByRangeDate(initDate , endDate , products);

        if(percent_cleared_payment_type && percent_cleared_payment)
          products = findByPercentClearedPayment(percent_cleared_payment_type , percent_cleared_payment , products);


          return products;
      }


      function findByEmployeeId(employee_id, productsAll)
      {

        var products;

        if(employee_id == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product)
          {
            return product.employee_id ==  employee_id;
          });
        }

        return products;

      }

      function findByClientId(client_id, productsAll)
      {

        var products;

        if(client_id == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product)
          {
            return product.client_id ==  client_id;
          });
        }

        return products;

      }

      function findBySaleType(sale_type, productsAll)
      {

        var products;

        if(sale_type == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product)
          {
            return product.sale_type ==  sale_type;
          });
        }

        return products;

      }

      function findByPayType(pay_type, productsAll)
      {

        var products;

        if(pay_type == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product)
          {
            if(product.hasOwnProperty('pay_type') && product.pay_type)
            {
               if(product.pay_type.hasOwnProperty('name')){
                  return product.pay_type.name ==  pay_type;
               }
            }

            return false;

          });
        }

        return products;

      }

      function findByPayTypeId(pay_type_id, productsAll)
      {

        var products;

        if(pay_type_id == '')
          products =  productsAll;
        else
        {
          products = productsAll.filter(function (product)
          {
            if(product.hasOwnProperty('pay_type_id') && product.pay_type_id)
            {

                  return product.pay_type_id ==  pay_type_id;
            }

            return false;

          });
        }

        return products;

      }

      function findBySaleDate(operator , saleDate , productsAll)
      {

        var products;

        if(operator == '' || saleDate == '')
          products = productsAll;
        else
        {
          products = productsAll.filter(function ( product )
          {


              if(product.hasOwnProperty('sale_date')){

                switch(operator)
                {
                  case '<':
                    return  product.sale_date  < saleDate;
                    break;
                  case '==':
                    return product.sale_date == saleDate;
                    break;
                  case '>':
                    return product.sale_date > saleDate;
                    break;

                }


            }

            return false;

          });
        }

        return products;
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

      function findByPercentClearedPayment(percent_cleared_payment_type , percent_cleared_payment , productsAll)
      {

        var products;

        if(percent_cleared_payment_type == '' || percent_cleared_payment == '')
          products = productsAll;
        else
        {
          products = productsAll.filter(function ( product )
          {

            switch(percent_cleared_payment_type)
            {
              case '<=':
                return  ( parseFloat(product.percent_cleared_payment) <= parseFloat(percent_cleared_payment) );
                break;
              case '==':
                return  ( parseFloat(product.percent_cleared_payment) == parseFloat(percent_cleared_payment) );
                break;
              case '>=':
                return  ( parseFloat(product.percent_cleared_payment) >= parseFloat(percent_cleared_payment) );
                break;
              default:
                return false;
                break;
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
        search2 : search2,
        getProducts : getProducts,
        getPacks : getPacks,
        API : API

      };

    }]);

})();
