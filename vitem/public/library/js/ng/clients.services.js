(function () {

  angular.module('clients.services', [])

    .factory('ClientsService', ['$http', '$q', '$filter' , function ($http, $q , $filter) {
      var normalize = $filter('normalize');      

      function all() {
        var deferred = $q.defer();

        $http.get('API/clients')
          .success(function (data) {
            deferred.resolve(data);
          });

        return deferred.promise;
      }

      function search(find, clientsAll , client_type_id , status , operatorEntryDate , entryDate) 
      {

        find = normalize(find);

        var clients;
        
        if(client_type_id)       
          clientsAll = findByClientTypeId(client_type_id , clientsAll);
        
        if(status)       
          clientsAll = findByStatus(status , clientsAll);

        if(operatorEntryDate && entryDate)                 
          clientsAll = findByEntryDate(operatorEntryDate , entryDate , clientsAll);

        if(find == '')
            clients =  clientsAll;
          else
          {
            clients = clientsAll.filter(function (user) {
              return normalize(user.id.toString()).indexOf(find) != -1 
                || normalize(user.name).indexOf(find) != -1
                || normalize(user.email).indexOf(find) != -1;
            });
          }

          return clients;
      }

      function findByClientTypeId(client_type_id, clientsAll) 
      {

        var clients;

        if(client_type_id == '')
          clients =  clientsAll;
        else
        {
          clients = clientsAll.filter(function (client) 
          {
            return client.client_type_id ==  client_type_id;
          }); 
        }        

        return clients;

      }

      function findByStatus(status, clientsAll) 
      {
        
        var clients;

        if(status == '')
          clients =  clientsAll;
        else
        {
          clients = clientsAll.filter(function (client) 
          {
            return client.status ==  status;
          }); 
        }        

        return clients;

      }

      function findByEntryDate(operator , entryDate , clientsAll)
      {

        var clients;

        if(operator == '' || entryDate == '')
          clients = clientsAll;
        else
        {
          clients = clientsAll.filter(function ( client )
          {
            
            if(client.hasOwnProperty('entry_date')){

                switch(operator)
                {
                  case '<':
                    return  client.entry_date  < entryDate;
                    break;
                  case '==':
                    return client.entry_date == entryDate;
                    break;
                  case '>':
                    return client.entry_date > entryDate;
                    break;

                }
            }

            return false;
            
          });
        }

        return clients;
      }


      return {
        all: all ,
        search : search,

      };

    }]);

})();
