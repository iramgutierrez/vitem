(function () {

  angular.module('expenses.services', [])

    .factory('ExpensesService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function all() {
        var deferred = $q.defer();

        $http.get('API/expenses')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function API( method , params) 
      {

        var deferred = $q.defer();

        var url = 'API/expenses/';

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

      function search(find, expensesAll , type) 
      { 

        find = normalize(find);

        var expenses;
       
        if(type) 
          expensesAll = findByType(type , expensesAll);

        
        if(find == '')
            expenses =  expensesAll;
          else
          {   
            expenses = expensesAll.filter(function (expense) {
          console.log(expense);
              return normalize(expense.id.toString()).indexOf(find) != -1
                || normalize(expense.concept).indexOf(find) != -1
                || normalize(expense.description).indexOf(find) != -1 
                || ( ( expense.hasOwnProperty('store') &&  expense.store ) ? normalize(expense.store.name).indexOf(find) != -1 : '' ) 
                || normalize(expense.employee.user.name).indexOf(find) != -1;
            });
          }   

          return expenses;
      }

      function findByType(type, expensesAll) 
      {

        var expenses;

        if(type == '')
          expenses =  destinationsAll;
        else
        {
          expenses = expensesAll.filter(function (expense) 
          {
            return expense.expense_type_id ==  type;
          }); 
        }        

        return expenses;

      }

      return {
        all: all ,
        search : search,
        API : API

      };

    }]);

})();
