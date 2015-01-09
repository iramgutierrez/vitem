@extends('layout')

@section('header')

@include('header' , [ 'css' => [
'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
]
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')

<div ng-app="deliveries">

	{{ Form::model( $delivery ,['route' => ['deliveries.update' , $delivery->id],  'name' => 'addDeliveriesForm' , 'method' => 'PATCH', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'EditController'  ]) }}

  	<div class="panel" ng-init="init({{ $id }})">

  	  	<header class="panel-heading">

  	    	<h1>Editar entrega</h1>

  	  	</header>

  	  	<div class="panel-body" >

          <div ng-show="sale_id">

            <div class="form-group col-md-12 col-sm-12 " >

              @include('deliveries/fields/delivery_date_edit')

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

    	  			@include('deliveries/fields/address')

    	      </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('deliveries/fields/destination')

            </div>

            <span class="col-md-12 col-sm-12 text-center">ó</span>
              
            <div class="form-group col-md-12 col-sm-12">

              @include('deliveries/fields/new_destination')              
              

            </div> 

            <div ng-if="newDestination">

              @include('deliveries/fields/new_destination_form') 
              
            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('deliveries/fields/employee_id')

            </div>         
            
            <div class="form-group col-md-12 ">                              
        
              <button type="submit" class="btn btn-success pull-right">Registrar</button>
      
            </div>

          </div>  

  		</div>

  	</div> 

  {{ Form::close() }}

</div>

@stop

@section('sidebar_right')

@include('sidebar_right')

@stop

@section('footer')

@include('footer', ['js' => [
        'library/js/ng/deliveries.js',
        'library/js/ng/deliveries.controllers.js',
        'library/js/ng/deliveries.services.js',
        'library/js/ng/destinations.services.js',
        'library/js/ng/destinations.filters.js',
        'library/js/ng/sales.services.js',
        'library/js/ng/users.services.js',
        'library/js/ng/users.filters.js',
        'library/js/ng/ng-date.js',
        'library/js/jquery-ui-1.9.2.custom.min.js' ,
        'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop