(function () {

  angular.module('expense_types.controllers', [])

    .controller('ExpenseTypesController', ['$scope', '$filter' , 'ExpenseTypeService' , function ($scope ,  $filter , ExpenseTypeService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.expense_types = [];

        ExpenseTypeService.API('all').then(function (data) {

          $scope.expense_types = data;

        });

        $scope.addExpenseType = function(event , valid)
        {
            $scope.addexpensetypeForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                

                ExpenseTypeService.add({

                    'id' : $scope.id,

                    'name' : $scope.name,

                })
                .then(function(data){ 

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.expense_types.push(data.expense_type);
                      else
                        $scope.expense_types[$scope.key] = data.expense_type;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.new = false;

                      $scope.addexpensetypeForm.submitted = false;

                    }

                })
            }
        }

        $scope.updateExpenseType = function (key , expense_type)
        {

          $scope.key = key;

          $scope.id = expense_type.id;

          $scope.name = expense_type.name;

          $scope.new = true;

          $scope.button = 'Actualizar'

        }

        $scope.newExpenseType = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
