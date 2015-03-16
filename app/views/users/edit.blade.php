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
                              <h1>Editar usuario</h1>
                          </header>
                          <div class="panel-body" ng-app="users">
                        		{{ Form::model( $user->toArray() , ['route' => ['users.update', $user->id] , 'method' => 'PATCH' , 'name' => 'addUserForm' , 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-submit' => 'addUserForm.$valid' ]) }}
                              		<div class="form-group col-md-6 col-sm-12">

                              			
                              			{{ Field::text(
                              					'name', 
                              					null , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => 'Ingresa el nombre completo',
                                          			'required',
                              					]
                              					)
                              			}}
                              		</div>
                                  @if(Auth::user()->role->level_id >= 3)

                                    @include('users/fields/store_id_edit')

                                  @endif
                              		<div class="form-group col-md-6 col-sm-12">
                              			{{ Field::text(
                              						'email', 
                              						null , 
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
                                          null , 
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
                                              'placeholder' => 'Ingresa una nueva contraseña'
                                            ]
                                        ) 
                                    }}
                                  </div>
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::password(
                                            'password_confirmation', 
                                            [ 
                                              'class' => 'col-md-12' , 
                                              'placeholder' => 'Confirma la nueva contraseña'
                                            ]
                                        ) 
                                    }}
                                  </div>
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::select(
                                            'role_id', 
                                            $roles,
                                            null , 
                                            [ 
                                              'class' => ' m-bot15  col-md-12' 
                                            ]
                                        ) 
                                    }}
                                  </div>  
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::image(
                                            'image_profile', 
                                            asset('images_profile/'.$user->image_profile),
                                            [ 
                                              'class' => 'col-md-12' , 
                                            ]
                                        ) 
                                    }}
                                  </div>  
                                  <div class="form-group col-md-6 col-sm-12">
                                  {{ Field::text(
                                                        'entry_date', 
                                                        $user->employee->entry_date ,
                                                        [ 
                                                            'ui-date' => 'dateOptions',
                                                            'ui-date-format' => 'yy-mm-dd',
                                                            'ng-model' => 'entryDate ',
                                                            'ng-init' => 'entryDate = "$user->employee->entry_date" '
                                                        ]
                                                ) 
                                        }}    
                                  </div>       

                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'street', 
                                          null , 
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
                                          null , 
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
                                          null, 
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
                                          null , 
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
                                          null , 
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
                                          null , 
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
                                          null , 
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
                              						null , 
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
                                              'ng-init' => "status = ".$user->status
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
                              						$user->employee->salary , 
                              						[ 
                              							'class' => 'col-md-12' , 
                              							'addon-first' => '$' , 
                              							'placeholder' => 'Ingresa el salario'
                              						]
                              					) 
                              			}}
                              		</div>                                 
                                   <div class="form-group col-md-12 ">                                  	 
                                  		<button type="submit" class="btn btn-success pull-right">Actualizar</button>
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