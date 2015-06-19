(function () {

  angular.module('colors.controllers', [])

    .controller('ColorsController', ['$scope', '$filter' , 'ColorService' , function ($scope ,  $filter , ColorService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.colors = [];

        ColorService.API('all').then(function (data) {

          $scope.colors = data;

        });

        $scope.addColor = function(event , valid)
        {
            $scope.addcolorForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                

                ColorService.add({

                    'id' : $scope.id,

                    'name' : $scope.name,

                })
                .then(function(data){ 

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.colors.push(data.color);
                      else
                        $scope.colors[$scope.key] = data.color;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.new = false;

                      $scope.addcolorForm.submitted = false;

                    }

                })
            }
        }

        $scope.updateColor = function (key , color)
        {

          $scope.key = key;

          $scope.id = color.id;

          $scope.name = color.name;

          $scope.new = true;

          $scope.button = 'Actualizar'

        }

        $scope.newColor = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
