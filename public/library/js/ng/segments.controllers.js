(function () {

  angular.module('segments.controllers', [])

    .controller('SegmentsController', ['$scope', '$filter' , 'SegmentService' , 'CatalogService', function ($scope ,  $filter , SegmentService , CatalogService ) {
        
        $scope.sort = 'id';

        $scope.reverse = false;

        $scope.segments = [];

        SegmentService.API('all').then(function (data) {

          $scope.segments = data;

        });

          $scope.catalogs = [];

          $scope.clearCatalogs = [];

          $scope.items = [];

          $scope.CatalogItem = [];

          CatalogService.API('all').then(function(catalogs){

              $scope.catalogs = catalogs;

              $scope.clearCatalogs = angular.copy($scope.catalogs);

          });

          $scope.getCatalogItems = function()
          {
              $scope.items = $scope.catalog.items;
          }

          $scope.addCatalogItem = function()
          {
              var item = {
                  catalog : $scope.catalog,
                  item : $scope.item
              };

              angular.forEach($scope.catalogs , function(catalog , c){

                  if(catalog.id == item.catalog.id)
                  {
                      $scope.catalogs.splice(c, 1);
                  }
              });

              $scope.items = [];

              $scope.catalog = '';

              $scope.item = '';

              $scope.CatalogItem.push(item);
          }

          $scope.removeCatalogItem = function(k , item)
          {
              $scope.CatalogItem.splice(k,1);

              $scope.catalogs.push(item.catalog);
          }

          $scope.reset = function()
          {
              $scope.CatalogItem = [];

              $scope.catalogs = angular.copy($scope.clearCatalogs);

              console.log($scope.catalogs);
          }

        $scope.addSegment = function(event , valid)
        {
            $scope.addsegmentForm.submitted = true;
            
            event.preventDefault();

            if(valid)
            {
                
                var segment = {

                    'id' : $scope.id,

                    'name' : $scope.name,

                    'CatalogItem' : []

                };

                angular.forEach($scope.CatalogItem , function(item){

                    segment.CatalogItem.push(item.item.id)

                });

                SegmentService.add(segment)
                .then(function(data){ 

                        $scope.reset();

                    if(data.hasOwnProperty('success'))
                    { 

                      if(!$scope.id)
                        $scope.segments.push(data.segment);
                      else
                        $scope.segments[$scope.key] = data.segment;

                      $scope.id = '';

                      $scope.key = '';

                      $scope.name = '';

                      $scope.new = false;

                      $scope.addsegmentForm.submitted = false;

                    }

                })
            }
        }

        $scope.updateSegment = function (key , segment)
        {

          $scope.key = key;

          $scope.id = segment.id;

          $scope.name = segment.name;

          $scope.new = true;

          $scope.button = 'Actualizar';

            angular.forEach(segment.catalog_items , function(item)
            {
                $scope.catalog  = item.catalog;

                $scope.item = item;

                $scope.addCatalogItem();
            })

        }

        $scope.newSegment = function ()
        {
          $scope.id = '';

          $scope.key = '';

          $scope.name = '';

          $scope.new = true;

          $scope.button = 'Registrar'
        }

    }]);

})();
