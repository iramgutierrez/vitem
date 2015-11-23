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


      function search(find, discountsAll , type , initDate , endDate , discountType, store , pay_type)
      { 

        find = normalize(find);

        var discounts;

          if(type)
              discountsAll = findByType(type , discountsAll);

          if(initDate)
              discountsAll = findByInitDate(initDate , discountsAll);

          if(endDate)
              discountsAll = findByEndDate(endDate , discountsAll);

          if(discountType)
              discountsAll = findByDiscountType(discountType , discountsAll);

          if(store)
              discountsAll = findByStore(store , discountsAll);

          if(pay_type)
              discountsAll = findByPayType(pay_type , discountsAll);
        
        if(find == '')
            discounts =  discountsAll;
          else
          {
            discounts = discountsAll.filter(function (discount) {

              return normalize(discount.id.toString()).indexOf(find) != -1
                || ((angular.isDefined(discount.item) && discount.item != null) ? normalize(discount.item.name).indexOf(find) != -1 : false );
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

      function findByType(type , discountsAll)
      {

          var discounts;

          if(type == '')
              discounts = discountsAll;
          else
          {
              discounts = discountsAll.filter(function ( discount )
              {
                  return discount.type == type;

              });
          }

          return discounts;
      }

      function findByInitDate(initDate , discountsAll)
      {

          var discounts;

          if(initDate == '')
              discounts = discountsAll;
          else
          {
              initDate += ' 00:00:00';

              discounts = discountsAll.filter(function ( discount )
              {

                  return discount.init_date >= initDate;

              });
          }

          return discounts;
      }

      function findByEndDate(endDate , discountsAll)
      {

          var discounts;

          if(endDate == '')
              discounts = discountsAll;
          else
          {
              endDate += ' 23:59:59';

              discounts = discountsAll.filter(function ( discount )
              {

                  return discount.end_date <= endDate;

              });
          }

          return discounts;
      }

      function findByDiscountType(discountType , discountsAll)
      {

          var discounts;

          if(discountType == '')
              discounts = discountsAll;
          else
          {
              discounts = discountsAll.filter(function ( discount )
              {
                  return discount.discount_type == discountType;

              });
          }

          return discounts;
      }

      function findByStore(store , discountsAll)
      {

          var discounts;

          if(store == '')
              discounts = discountsAll;
          else
          {
              discounts = discountsAll.filter(function ( discount )
              {

                  return discount.stores.filter(function(s){
                      return s.id == store;
                  }).length >= 1;

              });
          }

          return discounts;
      }

      function findByPayType(payType , discountsAll)
      {

          var discounts;

          if(payType == '')
              discounts = discountsAll;
          else
          {
              discounts = discountsAll.filter(function ( discount )
              {

                  return discount.pay_types.filter(function(p){
                          return p.id == payType;
                      }).length >= 1;

              });
          }

          return discounts;
      }

      return {
        
        API : API ,
        all : all ,
        search : search

      };

    }]);

})();
