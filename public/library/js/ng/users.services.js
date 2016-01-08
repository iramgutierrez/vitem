(function () {

  angular.module('users.services', [])

    .factory('UsersService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function all() {
        var deferred = $q.defer();

        $http.get('API/users')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function search(find, usersAll , role_id , status , operatorEntryDate , entryDate , operatorSalary , salary ) 
      {

        find = normalize(find);    

        var users;

        if(role_id)       
          usersAll = findByRoleId(role_id , usersAll);
        
        /*if(status)
          usersAll = findByStatus(status , usersAll);*/

        if(operatorEntryDate && entryDate)
          usersAll = findByEntryDate(operatorEntryDate , entryDate , usersAll);

        if(operatorSalary && salary)
          usersAll = findBySalary(operatorSalary , salary , usersAll);                  
        if(find == '')
            users =  usersAll;
          else
          {
            users = usersAll.filter(function (user) {
              return normalize(user.id.toString()).indexOf(find) != -1 
                || normalize(user.username).indexOf(find) != -1
                || normalize(user.email).indexOf(find) != -1
                || ( ( user.hasOwnProperty('store') &&  user.store ) ? normalize(user.store.name).indexOf(find) != -1 : '' ) 
                || normalize(user.name).indexOf(find) != -1;
            });
          }

          return users;
      }

      function findByRoleId(role_id, usersAll) 
      {

        var users;

        if(role_id == '')
          users =  usersAll;
        else
        {
          users = usersAll.filter(function (user) 
          {
            return user.role_id ==  role_id;
          }); 
        }        

        return users;

      }

      function getByRoleId(role_id) 
      {
        
        var deferred = $q.defer();

        $http.get('API/users/getByField?f=role_id&s=' + role_id )

          .success(function (data) {

            deferred.resolve(data);

          });

        return deferred.promise;

      }

      function findByStatus(status, usersAll) 
      {

        var users;

        if(status == '')
          users =  usersAll;
        else
        {
          users = usersAll.filter(function (user) 
          {
            return user.status ==  status;
          }); 
        }        

        return users;

      }

      function findByEntryDate(operator , entryDate , usersAll)
      {

        var users;

        if(operator == '' || entryDate == '')
          users = usersAll;
        else
        {
          users = usersAll.filter(function ( user )
          {
            console.log(entryDate);
            if(user.hasOwnProperty('employee')){
              if(user.employee.hasOwnProperty('entry_date')){

                switch(operator)
                {
                  case '<':
                    return  user.employee.entry_date  < entryDate;
                    break;
                  case '==':
                    return user.employee.entry_date == entryDate;
                    break;
                  case '>':
                    return user.employee.entry_date > entryDate;
                    break;

                }

              }
            }

            return false;
            
          });
        }

        return users;
      }

      function findBySalary(operator , salary , usersAll)
      {

        var users;

        if(operator == '' || salary == '')
          users = usersAll;
        else
        {
          users = usersAll.filter(function ( user )
          {

            if(user.hasOwnProperty('employee')){
              if(user.employee.hasOwnProperty('salary')){

                switch(operator)
                {
                  case '<':
                    return  user.employee.salary.toFixed(2)  < parseFloat(salary);
                    break;
                  case '==':
                    return user.employee.salary.toFixed(2) == parseFloat(salary);
                    break;
                  case '>':
                    return user.employee.salary.toFixed(2) > parseFloat(salary);
                    break;

                }

              }
            }

            return false;
            
          });
        }

        return users;
      }

        function API( method , params)
        {

          var deferred = $q.defer();

          var url = 'API/users/';

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
        all: all ,
        search : search,
        getByRoleId : getByRoleId,
        API : API


      };

    }]);

})();
