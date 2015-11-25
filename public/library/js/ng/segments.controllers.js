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

              var nameBeforeAdd = '';

              angular.forEach($scope.CatalogItem, function(item){

                  if(nameBeforeAdd != '')
                  {
                      nameBeforeAdd += ', ';
                  }
                  nameBeforeAdd += item.item.name;
              });

              $scope.CatalogItem.push(item);

              var nameAfterAdd = '';

              angular.forEach($scope.CatalogItem, function(item){

                  if(nameAfterAdd != '')
                  {
                      nameAfterAdd += ', ';
                  }
                  nameAfterAdd += item.item.name;
              });

              if(nameBeforeAdd == $scope.name || $scope.name == '')
              {
                  $scope.name = nameAfterAdd;
              }

          }

          $scope.removeCatalogItem = function(k , item)
          {



              var nameBeforeAdd = '';

              angular.forEach($scope.CatalogItem, function(item){

                  if(nameBeforeAdd != '')
                  {
                      nameBeforeAdd += ', ';
                  }
                  nameBeforeAdd += item.item.name;
              });

              $scope.CatalogItem.splice(k,1);

              var nameAfterAdd = '';

              angular.forEach($scope.CatalogItem, function(item){

                  if(nameAfterAdd != '')
                  {
                      nameAfterAdd += ', ';
                  }
                  nameAfterAdd += item.item.name;
              });

              if(nameBeforeAdd == $scope.name || $scope.name == '')
              {
                  $scope.name = nameAfterAdd;
              }

              $scope.catalogs.push(item.catalog);
          }

          $scope.reset = function()
          {
              $scope.CatalogItem = [];

              $scope.catalogs = angular.copy($scope.clearCatalogs);

              console.log($scope.catalogs);
          }

          $scope.message = false;

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
                      {
                          if(data.new)
                          {
                              $scope.segments.push(data.segment);

                              $scope.message = false;
                          }

                          else
                            $scope.message = 'Ya existe un criterio con los mismos valores, el id es: '+ data.segment.id;
                      }
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
