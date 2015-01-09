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

<div ng-app="sales">

	{{ Form::model( new Sale ,['route' => 'sales.store',  'name' => 'addsaleForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Nueva venta</h1>

  	  	</header>

  	  	<div class="panel-body" >

          <div class="form-group col-md-3 col-sm-3 pull-right " >

            @include('sales/fields/sheet')

          </div> 

          <div class="clearfix"></div>

          <div class="form-group col-md-4 col-sm-4" >

            @include('sales/fields/sale_date')

          </div> 

          <div class="form-group col-md-4 col-sm-4" >

            @include('sales/fields/pay_type')

          </div> 

          <div class="form-group col-md-4 col-sm-4" >

            @include('sales/fields/sale_type')

          </div> 

          <div class="form-group col-md-offset-4 col-sm-offset-4 col-md-4 col-sm-4" ng-show="sale_type == 'apartado' ">

            @include('sales/fields/liquidation_date')

          </div>

          <div class="form-group col-md-4 col-sm-4" ng-show="sale_type == 'apartado' ">

            @include('sales/fields/down_payment')

          </div> 

  	  		<div class="form-group col-md-12 col-sm-12 " >

  	  			 @include('sales/fields/employee_id')

  	    	</div> 

  	    	<div class="form-group col-md-12 col-sm-12 " >

  	  			@include('sales/fields/client_id')

  	    	</div>   



          @if($errors->first('PacksProductsSale'))

            <div class="form-group col-md-12 col-sm-12 " >
              
              <p class="error_message">{{ $errors->first('PacksProductsSale') }}</p>
            
            </div>

            

          @endif

          <div class="col-md-12 col-sm-12 " >

            <ul class="nav nav-tabs">

              <li class="active">
              
                <a data-toggle="tab" href="#" ng-click="addItems('product')" >Agregar productos</a>
                
              </li>
              
              <li class="">
                
                <a data-toggle="tab" href="#" ng-click="addItems('pack')">Agregar paquetes</a>
                
              </li>
              
            </ul>

          </div>        
          

  	    	<div class="form-group col-md-12 col-sm-12 " ng-show="showAddProducts" >

  	  			@include('sales/fields/products_sale')

  	    	</div> 

          <div class="form-group col-md-12 col-sm-12 " ng-show="showAddPacks" >

            @include('sales/fields/packs_sale')

          </div>

          <div class="col-md-12 col-sm-12 " >

            @include('sales/fields/table_products_packs')

          </div>

          {{--<div class="col-md-12 col-sm-12 " >

            @include('sales/fields/delivery')

          </div>--}}

          <div class="form-group col-md-12 ">                              
      
            <button type="submit" class="btn btn-success pull-right">Registrar</button>
    
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
        'library/js/ng/sales.js',
        'library/js/ng/sales.controllers.js',
        'library/js/ng/sales.services.js',
        'library/js/ng/users.services.js',
        'library/js/ng/clients.services.js',
        'library/js/ng/products.services.js',
        'library/js/ng/packages.services.js',
        'library/js/ng/destinations.services.js',
        'library/js/ng/ng-date.js',
        'library/js/ng/users.filters.js',
        'library/js/ng/commissions.filters.js',
        'library/js/ng/destinations.filters.js',
        'library/js/ng/directives.js',
        'library/js/jquery-ui-1.9.2.custom.min.js' ,
        'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop