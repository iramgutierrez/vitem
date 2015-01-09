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
                              <h1>Nuevo cliente</h1>
                          </header>
                          <div class="panel-body" ng-app="clients">
                        		{{ Form::model( new Client ,['route' => 'clients.store',  'name' => 'addclientForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-submit' => 'addclientForm.$valid' ]) }}
                              		<div class="form-group col-md-6 col-sm-12">
                                   
                              			{{ Field::text(
                              					'name', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => 'Ingresa el nombre completo',
                                          'required',
                                          'ng-model' => 'client.name'
                              						]
                              					)
                              			}}
                              		</div>
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::text(
                              						'email', 
                              						'' , 
                              						[ 
                              							'class' => 'col-md-12' , 
                              							'placeholder' => 'Ingresa el correo electrónico'
                              						]
                              					) 
                              			}}
                              		</div>
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'rfc', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el RFC'
                                          ]
                                        ) 
                                    }}
                                  </div>      
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'business_name', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa la razón social'
                                          ]
                                        ) 
                                    }}
                                  </div>      
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::image(
                                            'image_profile', 
                                            asset('images_profile/default.jpg'),
                                            [ 
                                              'class' => 'col-md-12' , 
                                            ]
                                        ) 
                                    }}
                                  </div>      
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::select(
                              							'client_type_id', 
                              							$client_types,
                              							'' ,
                              							[ 
                              								'class' => ' m-bot15  col-md-12' 
                              							]
                              					) 
                              			}}
                              		</div>    
                                  <div class="form-group col-md-6 col-sm-12">
                                  {{ Field::text(
                                                        'entry_date', 
                                                        '' ,
                                                        [ 
                                                            'ui-date' => 'dateOptions',
                                                            'ui-date-format' => 'yy-mm-dd',
                                                            'ng-model' => 'entryDate ',
                                                        ]
                                                ) 
                                        }}    
                                  </div>                                  
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'phone', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el teléfono'
                                          ]
                                        ) 
                                    }}
                                  </div>
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'street', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa la calle de la dirección'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'outer_number', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el número exterior'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'inner_number', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el número interior'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'zip_code', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el código postal'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'colony', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa la colonia'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'city', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa la ciudad, delegación o municipio'
                                          ]
                                        ) 
                                    }}
                                  </div>                                
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'state', 
                                          '' , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa el estado'
                                          ]
                                        ) 
                                    }}
                                  </div>  
                              		<div class="form-group col-md-6 col-sm-12">
                              			<?php echo  Field::checkbox(
                                            'status', 
                                            '1',
                                            [
                                              'ng-model' => 'status',
                                              'ng-true-value' => "1",
                                              'ng-false-value' => "0",
                                              'ng-init' => "status = 0"
                                            ] ,
                                            [
                                              'label-value' => '{{ status | boolean }}',
                                            ]                                     
                                        ) 
                                    ?>
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
                  'library/js/ng/clients.js',
                  'library/js/ng/clients.controllers.js',
                  'library/js/ng/clients.services.js',
                  'library/js/ng/clients.filters.js',
                  'library/js/ng/clients.directives.js',
                                'library/js/ng/directives.js',
                  'library/js/ng/ng-date.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    							'library/js/bootstrap-switch.js' ,
    							'library/js/jquery.tagsinput.js' ,
    							'library/js/ga.js' ,
                  'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
    							]
    				   ]
    		)

@stop