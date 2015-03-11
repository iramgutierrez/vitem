@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    								'library/assets/bootstrap-datepicker/css/datepicker.css',
    								'library/assets/bootstrap-colorpicker/css/colorpicker.css',
    								'library/assets/bootstrap-daterangepicker/daterangepicker.css',
                    				'library/assets/bootstrap-fileupload/bootstrap-fileupload.css',
                    				'library/css/bootstrap-switch.css'
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')
<div class="panel"  >

	<header class="panel-heading">
    
        <h1>Configuración general.</h1>
    
    </header>
    <div class="panel-body" ng-app="settings">
    	{{ Form::model( $settings ,['route' => 'settings.store',  'name' => 'addsettingForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}

	        <div class="form-group col-md-12 col-sm-12">

	        	@include('settings/fields/residue')                                   
            	
            </div> 

            <div class="form-group col-md-12 col-sm-12">

	        	@include('settings/fields/add_residue_new_sale')                                   
            	
            </div>    

            <div class="form-group col-md-12 col-sm-12">

	        	@include('settings/fields/add_residue_new_sale_payment')                                   
            	
            </div>    

            <div class="form-group col-md-12 col-sm-12">

	        	@include('settings/fields/add_residue_new_commission')                                   
            	
            </div>    

            <div class="form-group col-md-12 col-sm-12">

	        	@include('settings/fields/add_residue_new_expense')                                   
            	
            </div>

			<div class="form-group col-md-12 col-sm-12">

				@include('settings/fields/add_residue_new_delivery')

			</div>

            <div class="form-group col-md-12 col-sm-12">

                @include('settings/fields/add_residue_new_order')

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
    			  'library/js/ng/bootstrap-switch.js',
    			  'library/js/ng/module-frapontillo.bootstrap-switch.js',
    			  'library/js/ng/bsSwitch.js',
    			  'library/js/ng/settings.js',
    			  'library/js/ng/settings.controllers.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    			  'library/js/jquery.tagsinput.js' ,
    			  'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop