@extends('layout')

@section('header')

@include('header' , [ 'css' => [
'library/assets/bootstrap-datepicker/css/datepicker.css',
'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
]
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')

<div ng-app="deliveries"> {{ $newDestination }} 


	{{ Form::model( new Delivery ,['route' => 'deliveries.store',  'name' => 'addDeliveryForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')' ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Entrega</h1>

  	  	</header>

  	  	<div class="panel-body" >    	  	  

  	  	  <div class="col-md-12 col-sm-12" >

  	  			@include('deliveries/fields/sheet_sale')  	  			  

  	      </div>  

          <div ng-show="error" class="col-sm-12" >

            <h2 class="text-center error">@{{ error }}</h2>
            
          </div> 

          <div ng-show="sale_id" class="col-sm-12">

            <div class="form-group col-md-12 col-sm-12 " >

              @include('deliveries/fields/address')

            </div>

            <div class="form-group col-md-6 col-sm-6 " >

              @include('deliveries/fields/delivery_date')

            </div>

            <div class="form-group col-md-6 col-sm-6 ">

              <label for="pay_type">Forma de pago</label>

              <select class="form-control" name="pay_type_id" ng-model="pay_type_id" ng-init="pay_type_id = {{ Input::old('pay_type_id') }}">
                <option value="" selected="selected">Seleccione</option>

                <option value="@{{ type.id }}" ng-selected="type.id == {{ Input::old('pay_type_id')  }}" ng-repeat="type in pay_types">@{{ type.name }}</option>

              </select>

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('deliveries/fields/destination')

            </div>

            <span ng-if="$root.auth_permissions.create.destination" class="col-md-12 col-sm-12 text-center">ó</span>
              
            <div ng-show="$root.auth_permissions.create.destination"  class="form-group col-md-12 col-sm-12">

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

          <div ng-show="deliveryExists">

            <br><br>
            
            <h4 class="text-center"> @{{ deliveryExists }} </h4>
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