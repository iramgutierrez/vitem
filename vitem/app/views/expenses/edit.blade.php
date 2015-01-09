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
                              <h1>Editar gasto</h1>
                          </header>
                          <div class="panel-body" ng-app="expenses" > 
                        		{{ Form::model( $expense ,['route' => ['expenses.update' , $expense->id],  'name' => 'addExpenseForm' , 'method' => 'PATCH', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}
                              		
                              		
                              		<div class="form-group col-md-6 col-sm-12">
                                   
                              			{{ Field::text(
                              					'concept', 
                              					null , 
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
                              					null , 
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
                              					null , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              					]
                              				)
                              			}}
                              		</div>   


                              		<div class="form-group col-md-4 col-sm-12 " >

						              @include('expenses/fields/date_edit')

						            </div> 

                              		  

                              		<div class="form-group col-md-4 col-sm-12">
                                   
                              			{{ Field::text(
                              					'quantity', 
                              					null , 
                              					[ 
                              						'class' => 'col-md-12' , 
                              						'placeholder' => '',
                              						'addon-first' => '$'
                              					]
                              				)
                              			}}
                              		</div>   

						            <div class="form-group col-md-12 col-sm-12 " >

						              @include('expenses/fields/employee_id_edit')

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