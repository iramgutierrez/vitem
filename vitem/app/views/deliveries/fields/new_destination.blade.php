<?php 

              $newDestinationAttr = [
                      'ng-model' => 'newDestination',
                      'ng-true-value' => "1",
                      'ng-false-value' => "0",
                      'ng-change' => 'checkNewDestination()'
              ];
              
              if((Session::has('newDestination')))
              {


               
                $newDestinationAttr['ng-init'] = 'newDestination = ' . Session::get('newDestination');   
               
              }

              echo  Field::checkbox(
                'new_destination', 
                
                '1',
                
                $newDestinationAttr ,
                
                [
                
                  'label-value' => 'Agrega un nuevo destino',
                
                ]                                     
                
              ) 
              
              ?>