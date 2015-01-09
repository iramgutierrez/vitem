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
                              <h1>Nuevo gasto</h1>
                          </header>
                          <div class="panel-body" ng-app="expenses">
                        		{{ Form::model( new Expense ,['route' => 'expenses.store',  'name' => 'addexpenseForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}
                              		<div class="form-group col-md-6 col-sm-12">
                                   
                              			{{ Field::text(
                              					'concept', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              					]
                              				)
                              			}}
                              		</div>
                              		<div class="form-group col-md-6 col-sm-12">
                                   
                              			{{ Field::textarea(
                              					'description', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              					]
                              				)
                              			}}
                              		</div>  
                              		<div class="form-group col-md-4 col-sm-12">
                                   
                              			{{ Field::select(
                              					'expense_type_id', 
                              					$types,
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              					]
                              				)
                              			}}
                              		</div>   

                              		<div class="form-group col-md-4 col-sm-12">
                                   
                              			{{ Field::text(
                              					'date', 
                              					'' , 
                              					[ 
        									            	  'ui-date' => 'dateOptions',
        									                'ui-date-format' => 'yy-mm-dd',
        									                'ng-model' => 'date',
                                          'ng-init' => 'date ="Input::old(\'date\')"',
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              						'addon-first' => '<i class="fa fa-calendar"></i>'
                              					]
                              				)
                              			}}
                              		</div>   

                              		<div class="form-group col-md-4 col-sm-12">
                                   
                              			{{ Field::text(
                              					'quantity', 
                              					'' , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              						'addon-first' => '$'
                              					]
                              				)
                              			}}
                              		</div>   

						            <div class="form-group col-md-12 col-sm-12 " >

						              @include('expenses/fields/employee_id')

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
                  'library/js/ng/expenses.js',
                  'library/js/ng/expenses.controllers.js',
                  'library/js/ng/expenses.services.js',
                  'library/js/ng/users.services.js',
                  'library/js/ng/users.filters.js',
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