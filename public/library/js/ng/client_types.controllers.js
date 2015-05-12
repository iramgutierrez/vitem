(function () {

  angular.module('client_types.controllers', [])

    .controller('ClientTypesController', ['$scope', '$filter' , 'ClientTypeService' , function ($scope ,  $filter , ClientTypeService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.client_types = [];

        ClientTypeService.API('all').then(function (data) {

          $scope.client_types = data;

        });

        $scope.addClientType = function(event , valid)
        {
            $scope.addclienttypeForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                

                ClientTypeService.add({

                    'id' : $scope.id,

                    'name' : $scope.name,

                })
                .then(function(data){ 

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.client_types.push(data.client_type);
                      else
                        $scope.client_types[$scope.key] = data.client_type;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.new = false;

                      $scope.addclienttypeForm.submitted = false;

                    }

                })
            }
        }

        $scope.updateClientType = function (key , client_type)
        {

          $scope.key = key;

          $scope.id = client_type.id;

          $scope.name = client_type.name;

          $scope.new = true;

          $scope.button = 'Actualizar'

        }

        $scope.newClientType = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
