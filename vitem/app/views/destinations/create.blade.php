@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    								'library/assets/bootstrap-datepicker/css/datepicker.css',
    								'library/assets/bootstrap-colorpicker/css/colorpicker.css',
    								'library/assets/bootstrap-daterangepicker/daterangepicker.css',
                    				'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')
<div class="panel">



                          <header class="panel-heading">
                              <h1>Nuevo destino</h1>
                          </header>
                          <div class="panel-body" ng-app="destinations">
                        		{{ Form::model( new Destination ,['route' => 'destinations.store',  'name' => 'adddestinationForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}
                              		
                              		<!--<div class="form-group col-md-6 col-sm-12" >
                                   
                              			{{ Field::text(
                              					'delivery_days', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'delivery_days',
                              					]
                              					)
                              			}}
                              		</div>   -->
                              		<div class="form-group col-md-12 col-sm-12" >
                                   
                              			{{ Field::text(
                              					'cost', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                    'ng-model' => 'cost', 
                              						'addon-first' => '$' ,
			                                    'ng-init' => "cost = '".Input::old('cost')."'" 
                              					]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-12 col-sm-12">
                                   
                              			{{ Field::select(
                              					'type', 
                              					$types,
                              					null , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'type',
			                                        'ng-init' => "type = '".Input::old('type')."'"
                              					]
                              					)
                              			}}
                              		</div>  
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type == 1" >
                                   
                              			{{ Field::text(
                              					'zip_code', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'zip_code',
			                                        'ng-init' => "zip_code = '".Input::old('zip_code')."'"
                              					]
                              					)
                              			}}
                              		</div>    
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1 && type <= 2">
                                   
                              			{{ Field::text(
                              					'colony', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'colony',
			                                        'ng-init' => "colony = '".Input::old('colony')."'"
			                                    ]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1 && type <= 3">
                                   
                              			{{ Field::text(
                              					'town', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'town',
			                                        'ng-init' => "town = '".Input::old('town')."'"
                              					]
                              					)
                              			}}
                              		</div>   
                              		<div class="form-group col-md-6 col-sm-12" ng-show="type >= 1">
                                   
                              			{{ Field::text(
                              					'state', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
			                                        'ng-model' => 'state',
			                                        'ng-init' => "state = '".Input::old('state')."'"
                              					]
                              					)
                              			}}
                              		</div>                            		                        
                                   <div class="form-group col-md-12 ">                                  	 
                                  		<button type="submit" class="btn btn-success pull-right">Registrar</button>
                                   </div>
                               	{{ Form::close() }}
                          </div>
                          </div>
	
@stop

@section('sidebar_right')

    @include('sidebar_right')

@stop

@section('footer')

    @include('footer', ['js' => [
                                'library/js/ng/destinations.js',
                                'library/js/ng/destinations.controllers.js',
                                'library/js/ng/destinations.services.js',
                                'library/js/ng/destinations.filters.js',
                                'library/js/ng/directives.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    			  'library/js/bootstrap-switch.js' ,
    			  'library/js/jquery.tagsinput.js' ,
    			  'library/js/ga.js' ,
                  'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
    							]
    				   ]
    		)

@stop