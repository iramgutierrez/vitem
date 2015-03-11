<?php 

              $newDestinationAttr = [
                      'ng-model' => 'newDestination',
                      'ng-true-value' => "1",
                      'ng-false-value' => "0",
                      'ng-change' => 'autocompleteDestination = 0'
              ];

              if((Session::has('newSupplier')))
              {
               
                $newDestinationAttr['ng-init'] = 'newSupplier = ' . Session::get('newSupplier');   
               
              }

              echo  Field::checkbox(
                '', 
                
                '1',
                
                $newDestinationAttr ,
                
                [
                
                  'label-value' => 'Agrega un nuevo destino',
                
                ]                                     
                
              ) 
              
              ?><?php 

              $newDestinationAttr = [
                      'ng-model' => 'newDestination',
                      'ng-true-value' => "1",
                      'ng-false-value' => "0",
                      'ng-change' => 'autocompleteDestination = 0'
              ];

              if((Session::has('newSupplier')))
              {
               
                $newDestinationAttr['ng-init'] = 'newSupplier = ' . Session::get('newSupplier');   
               
              }

              echo  Field::checkbox(
                '', 
                
                '1',
                
                $newDestinationAttr ,
                
                [
                
                  'label-value' => 'Agrega un nuevo destino',
                
                ]                                     
                
              ) 
              
              ?>