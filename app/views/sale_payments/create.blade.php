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

	{{ Form::model( new SalePayment ,['route' => 'sale_payments.store',  'name' => 'addsalePaymentForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'SalePaymentController'  ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Nuevo abono</h1>

  	  	</header>

  	  	<div class="panel-body" >



  	  	  <div class="col-md-6 col-sm-6" >

  	  			@include('sale_payments/fields/sheet_sale')



  	      </div>
  	      <div class="clearfix"></div>

          <div class="col-sm-12" ng-show="error">

            <h2 class="text-center error" >@{{ error }}</h2>

          </div>

          <div ng-show="sale_id && !error">

            <div class="form-group col-md-12 col-sm-12 " >

              <table class="table table-bordered table-striped table-condensed">
                <tr>
                  <td>Folio de venta</td>
                  <td>@{{ sale.sheet }}</td>
                </tr>
                <tr>
                  <td>Fecha</td>
                  <td>@{{ sale.sale_date }}</td>
                </tr>
                <tr>
                  <td>Vendedor</td>
                  <td>@{{ sale.employee.user.name }}</td>
                </tr>
                <tr>
                  <td>Cantidad pagada</td>
                  <td>@{{ sale.cleared_payment | currency }}</td>
                </tr>
                <tr>
                  <td>Cantidad restante</td>
                  <td>@{{ sale.remaining_payment | currency }}</td>
                </tr>
              </table>

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

    	  			@include('sale_payments/fields/employee_id')

    	      </div>

            <div class="form-group col-md-4 col-sm-6" >

              @include('sale_payments/fields/pay_type')

            </div>

            <div class="form-group col-md-4 col-sm-6" >

              @include('sale_payments/fields/quantity')

            </div>

            <div class="form-group col-md-4 col-sm-6" >

              @include('sale_payments/fields/date')

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              <table class="table table-bordered table-striped table-condensed">
                <tr>
                  <td>Subtotal</td>
                  <td>@{{ subtotal | currency }}</td>
                </tr>
                <tr>
                  <td>Comisión por forma de pago</td>
                  <td>@{{ commission_pay | currency }}</td>
                </tr>
                <tr>
                  <td>Total a pagar</td>
                  <td>@{{ total | currency }}</td>
                </tr>
              </table>

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
            'library/js/ng/colors.services.js',
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )


@stop