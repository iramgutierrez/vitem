<?php 

              $newDestinationAttr = [
                      'ng-model' => 'newDestination',
                      'ng-true-value' => "1",
                      'ng-false-value' => "0",
                      'ng-change' => 'checkNewDestination()',
                      'ng-init' => 'newDestination = checkValuePreOrOld("'.((!empty($sale->delivery->new_destination)) ? $sale->delivery->new_destination : '').'" , "'.((Input::old('delivery.new_destination')) ? Input::old('delivery.new_destination') : '').'")',
                      'ng-checked' => 'checkValuePreOrOld("'.((!empty($sale->delivery->new_destination)) ? $sale->delivery->new_destination : '').'" , "'.((Input::old('delivery.new_destination')) ? Input::old('delivery.new_destination') : '').'")'
              ];

              echo  Field::checkbox(
                'delivery.new_destination', 
                
                '1',
                
                $newDestinationAttr ,
                
                [
                
                  'label-value' => 'Agrega un nuevo destino',
                
                ]                                     
                
              ) 
              
              ?>