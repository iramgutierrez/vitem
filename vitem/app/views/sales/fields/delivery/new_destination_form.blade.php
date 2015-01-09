<h4>Nuevo destino</h4>

<div class="form-group col-md-12 col-sm-12" >
                                   
                              			{{ Field::text(
                              					'delivery.destination.cost', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                    'ng-model' => 'cost', 
                              						'addon-first' => '$' ,
			                                    'ng-init' => "cost = '".Input::old('destination.cost')."'" 
                              					]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-12 col-sm-12">
                                   
                              			{{ Field::select(
                              					'delivery.destination.type', 
                              					$destination_types,
                              					null , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'type',
			                                        'ng-init' => "type = '".Input::old('destination.type')."'"
                              					]
                              					)
                              			}}
                              		</div>  
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type == 1" >
                                   
                              			{{ Field::text(
                              					'delivery.destination.zip_code', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'zip_code',
			                                        'ng-init' => "zip_code = '".Input::old('destination.zip_code')."'"
                              					]
                              					)
                              			}}
                              		</div>    
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1 && type <= 2">
                                   
                              			{{ Field::text(
                              					'delivery.destination.colony', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'colony',
			                                        'ng-init' => "colony = '".Input::old('destination.colony')."'"
			                                    ]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1 && type <= 3">
                                   
                              			{{ Field::text(
                              					'delivery.destination.town', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'town',
			                                        'ng-init' => "town = '".Input::old('destination.town')."'"
                              					]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1">
                                   
                              			{{ Field::text(
                              					'delivery.destination.state', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'state',
			                                        'ng-init' => "state = '".Input::old('destination.state')."'"
                              					]
                              					)
                              			}}
                              		</div> 