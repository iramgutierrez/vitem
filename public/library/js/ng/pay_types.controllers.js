(function () {

  angular.module('pay_types.controllers', [])

    .controller('PayTypesController', ['$scope', '$filter' , 'PayTypeService' , function ($scope ,  $filter , PayTypeService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.pay_types = [];

        PayTypeService.API('all').then(function (data) {

          $scope.pay_types = data;

          console.log($scope.pay_types)

        });

        $scope.addPayType = function(event , valid)
        {
            $scope.addpaytypeForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                

                PayTypeService.add({

                    'id' : $scope.id,

                    'name' : $scope.name,

                    'percent_commission' : $scope.percent_commission,

                })
                .then(function(data){  console.log(data);

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.pay_types.push(data.pay_type);
                      else
                        $scope.pay_types[$scope.key] = data.pay_type;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.percent_commission = '';

                      $scope.new = false;

                      $scope.addpaytypeForm.submitted = false;

                    }

                })
            }
        }

        $scope.updatePayType = function (key , pay_type)
        {

          $scope.key = key;

          $scope.id = pay_type.id;

          $scope.name = pay_type.name;

          $scope.percent_commission = pay_type.percent_commission;

          $scope.new = true;

          $scope.button = 'Actualizar'

        }

        $scope.newPayType = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.percent_commission = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
