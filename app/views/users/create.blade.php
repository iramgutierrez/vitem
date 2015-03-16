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
                              <h1>Nuevo usuario</h1>
                          </header>
                          <div class="panel-body" ng-app="users">
                        		{{ Form::model( new User ,['route' => 'users.store',  'name' => 'addUserForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-submit' => 'addUserForm.$valid' ]) }}
                              		<div class="form-group col-md-6 col-sm-12">
                                   
                              			{{ Field::text(
                              					'name', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => 'Ingresa el nombre completo',
                                          'required',
                                          'ng-model' => 'user.name'
                              						]
                              					)
                              			}}
                              		</div>
                                  @if(Auth::user()->role->level_id >= 3)

                                    @include('users/fields/store_id')

                                  @endif
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
                              						'username', 
                              						'' , 
                              						[ 
                              							'class' => 'col-md-12' , 
                              							'placeholder' => 'Ingresa el nombre de usuario'
                              						]
                              					) 
                              			}}
                              		</div>
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::password(
                              							'password', 
                              							[ 
                              								'class' => 'col-md-12' , 
                              								'placeholder' => 'Ingresa una contraseña'
                              							]
                              					) 
                              			}}
                              		</div>
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::password(
                              							'password_confirmation', 
                              							[ 
                              								'class' => 'col-md-12' , 
                              								'placeholder' => 'Confirma la contraseña'
                              							]
                              					) 
                              			}}
                              		</div>
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::select(
                              							'role_id', 
                              							$roles,
                              							'' ,
                              							[ 
                              								'class' => ' m-bot15  col-md-12' 
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
                                  {{ Field::text(
                                                        'entry_date', 
                                                        '' ,
                                                        [ 
                                                            'ui-date' => 'dateOptions',
                                                            'ui-date-format' => 'yy-mm-dd',
                                                            'ng-model' => 'entryDate ',
                                                            'placeholder' => 'Ingresa la fecha en que ingreso el usuario'
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
                              		<!--<div class="form-group col-md-6 col-sm-12">
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
                              		</div>-->
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::text(
                              						'salary', 
                              						'' , 
                              						[ 
                              							'class' => 'col-md-12' , 
                              							'addon-first' => '$' , 
                              							'placeholder' => 'Ingresa el salario'
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
                  'library/js/ng/users.js',
                  'library/js/ng/users.controllers.js',
                  'library/js/ng/users.services.js',
                  'library/js/ng/sales.services.js',
                  'library/js/ng/users.filters.js',
                  'library/js/ng/commissions.filters.js',
                  'library/js/ng/users.directives.js',
                  'library/js/ng/ng-date.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    							'library/js/bootstrap-switch.js' ,
    							'library/js/jquery.tagsinput.js' ,
    							'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop