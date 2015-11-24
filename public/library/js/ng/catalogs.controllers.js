(function () {

  angular.module('catalogs.controllers', [])

    .controller('CatalogsController', ['$scope', '$filter' , 'CatalogService' , function ($scope ,  $filter , CatalogService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.catalogs = [];

        CatalogService.API('all').then(function (data) {

          $scope.catalogs = data;

        });

          $scope.setItem = function(item , catalog)
          {
              $scope.item_id = item.id;

              $scope.catalog_id = catalog.id;

              $scope.item_name = item.name;

              $scope.catalog_name = catalog.name;
          }

        $scope.addCatalog = function(event , valid)
        {
            $scope.addcatalogForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                

                CatalogService.add({

                    'id' : $scope.id,

                    'name' : $scope.name,

                })
                .then(function(data){ 

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.catalogs.push(data.catalog);
                      else
                        $scope.catalogs[$scope.key] = data.catalog;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.new = false;

                      $scope.addcatalogForm.submitted = false;

                    }

                })
            }
        }

        $scope.updateCatalog = function (key , catalog)
        {

          $scope.key = key;

          $scope.id = catalog.id;

          $scope.name = catalog.name;

          $scope.new = true;

          $scope.button = 'Actualizar'

        }

        $scope.newCatalog = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
