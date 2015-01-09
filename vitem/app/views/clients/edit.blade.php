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
                              <h1>Editar cliente</h1>
                          </header> 
                          <div class="panel-body" ng-app="clients">
                            {{ Form::model( $client->toArray() , ['route' => ['clients.update', $client->id] , 'method' => 'PATCH' , 'name' => 'addclientForm' , 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-submit' => 'addclientForm.$valid' ]) }}
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
                                    {{ Field::image(
                                            'image_profile', 
                                            asset('images_profile_clients/'.$client->image_profile),
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
                                            null , 
                                            [ 
                                              'class' => ' m-bot15  col-md-12' 
                                            ]
                                        ) 
                                    }}
                                  </div>                                      
                                  <div class="form-group col-md-6 col-sm-12">
                                  {{ Field::text(
                                                        'entry_date',                                                         
                                                        $client->entry_date ,
                                                        [ 
                                                            'ui-date' => 'dateOptions',
                                                            'ui-date-format' => 'yy-mm-dd',
                                                            'ng-model' => 'entryDate',
                                                            'ng-init' => 'entryDate = "$client->entry_date" '
                                                        ]
                                                ) 
                                        }}    
                                  </div>
                                  <div class="form-group col-md-6 col-sm-12">
                                    {{ Field::text(
                                          'rfc', 
                                          null , 
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
                                          null , 
                                          [ 
                                            'class' => 'col-md-12' ,
                                             'placeholder' => 'Ingresa la razón social'
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
                                  <div class="form-group col-md-6 col-sm-12">
                                    <?php echo  Field::checkbox(
                                            'status', 
                                            '1',
                                            [
                                              'ng-model' => 'status',
                                              'ng-true-value' => "1",
                                              'ng-false-value' => "0",
                                              'ng-init' => "status = ".$client->status
                                            ] ,
                                            [
                                              'label-value' => '{{ status | boolean }}',
                                            ]                                     
                                        ) 
                                    ?>
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