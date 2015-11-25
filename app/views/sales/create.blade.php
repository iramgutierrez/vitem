@extends('layout')

@section('header')

@include('header' , [ 'css' => [
'library/assets/bootstrap-fileupload/bootstrap-fileupload.css',
'library/assets/dropzone/css/dropzone.css'
]
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')

<div ng-app="sales">

	{{ Form::model( new Sale ,['route' => 'sales.store',  'name' => 'addsaleForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')'  ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Nueva venta</h1>

  	  	</header>

  	  	<div class="panel-body" >

          <div class="form-group col-md-3 col-sm-3 pull-right " ng-init="getNextSheet()">

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

          @if(Auth::user()->role->level_id >= 3)

            @include('sales/fields/store_id')

          @else

            <div ng-init="store_id = {{ Auth::user()->store_id }}; $root.store_id = {{ Auth::user()->store_id }}; " ></div>

          @endif


          @if(Auth::user()->role->level_id > 1)

  	  		<div class="form-group col-md-12 col-sm-12 " >

  	  			 @include('sales/fields/employee_id')

  	    	</div>

          @endif


            <div ng-if="$root.auth_permissions.create.client" class="col-sm-4 col-md-4 col-sm-offset-8 col-md-offset-8 text-right">

                <a data-toggle="modal" href="#addClient" >

                    <button type="button" class="col-sm-6 col-sm-offset-6 btn btn-danger">Crear nuevo cliente</button>

                </a>

            </div>


  	    	<div class="form-group col-md-12 col-sm-12 " >

  	  			@include('sales/fields/client_id')

  	    	</div>



          @if($errors->first('PacksProductsSale'))

            <div class="form-group col-md-12 col-sm-12 " >

              <p class="error_message">{{ $errors->first('PacksProductsSale') }}</p>

            </div>



          @endif

          <div class="col-md-8 col-sm-8 " >

            <ul class="nav nav-tabs">

              <li class="active">

                <a data-toggle="tab" href="#" ng-click="tab = 'pack'">Agregar paquetes</a>

              </li>

              <li class="">

                <a data-toggle="tab" href="#" ng-click="tab = 'product'" >Agregar productos existente</a>

              </li>

            </ul>

          </div>

          <div class="col-sm-4 col-md-4 text-right" ng-if="$root.auth_permissions.create.product">

            <a data-toggle="modal" href="#addProduct" >

              <button type="button" class="col-sm-6 col-sm-offset-6 btn btn-danger" >Crear nuevo producto <br>y agregarlo a la venta</button>

            </a>

          </div>

  	    	<div class="form-group col-md-12 col-sm-12 " ng-show="tab == 'product'" >

  	  			@include('sales/fields/products_sale')

  	    	</div>

          <div class="form-group col-md-12 col-sm-12 " ng-show="tab == 'pack'" >

            @include('sales/fields/packs_sale')

          </div>

          <div class="col-md-12 col-sm-12 " >

                @include('sales/fields/table_products_packs')

          </div>

          {{--<div class="col-sm-12 col-md-12">

              <div class="col-sm-12">


                  <table class="table table-bordered table-striped table-condensed" ng-show="destination && !newDestination && delivery_tab == 1">
                      <tr>
                          <th>Tipo de destino</th>
                          <th>Código postal</th>
                          <th>Colonia</th>
                          <th>Delegación/Municipio</th>
                          <th>Estado</th>
                          <th>Costo</th>
                      </tr>
                      <tr>
                          <td>@{{destination.type | destination_types }}</td>
                          <td>@{{ destination.zip_code  }}</td>
                          <td>@{{ destination.colony  }}</td>
                          <td>@{{ destination.town  }}</td>
                          <td>@{{ destination.state }}</td>
                          <td>@{{ destination.cost | currency }}</td>
                      </tr>
                  </table>

              </div>

          </div>--}}

          <div class="col-sm-12 col-md-12">

              <div class="col-sm-2 col-sm-offset-10">


                  <table class="table table-bordered table-striped table-condensed" ng-show="destination && !newDestination && delivery_tab == 1">
                      <tr>
                          <th colspan="5">Total</th>
                          <th>@{{ getFinalPrice();  }}</th>
                      </tr>
                  </table>

              </div>

          </div>

            <div ng-show="$root.auth_permissions.create.delivery">

              @include('sales/fields/delivery')

            </div>

          <div class="form-group col-md-12 ">

            <button type="submit" class="btn btn-success pull-right">Registrar</button>

          </div>


  		</div>

  	</div>

  {{ Form::close() }}

  <div ng-show="$root.auth_permissions.create.product">

    @include('sales/fields/new_product')

  </div>

  <div ng-show="$root.auth_permissions.create.client">

    @include('sales/fields/new_client')

  </div>

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
        'library/assets/bootstrap-fileupload/bootstrap-fileupload.js',


        /*new product */
        'library/js/ng/products.filters.js',
        'library/js/ng/products.services.js',
        'library/js/ng/suppliers.services.js',
        'library/js/ng/segments.services.js',
        'library/assets/dropzone/dropzone.js',
        'library/js/jquery.validate.min.js'


        /*new product */
]
]
)


@stop