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

<div ng-app="commissions">

	{{ Form::model( $commission ,['route' => ['commissions.update' , $commission->id],  'name' => 'addCommissionsForm' , 'method' => 'PATCH', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'EditController'  ]) }}

  	<div class="panel" ng-init="init({{ $id }})">

  	  	<header class="panel-heading">

  	    	<h1>Editar comisión</h1>

  	  	</header>

  	  	<div class="panel-body" >

  	  	  <h4>Tipo de venta: <span> @{{ sale.sale_type }}</span></h4>

  	  	  <div ng-show="sale.sale_type == 'apartado'">

	  	  	  <p> {{ Form::radio('commission_type', 'total' , false , ['ng-model' => 'commission_type' , 'ng-change' => 'getTotals()']) }} Comisionar sobre el total de la venta </p>

	  	  	  <p> {{ Form::radio('commission_type', 'sale_payments', true, ['ng-model' => 'commission_type' , 'ng-change' => 'getTotals()' ]) }} Comisionar sobre un conjunto de abonos. </p>

	  	  </div>

  	  	  <table class="table table-bordered table-striped table-condensed">
  	  	  <tr>
  	  	  	<th  colspan="4" class="text-right">Vendedor que realizo la venta:</th>
  	  	  	<th >@{{ sale.employee.user.name }}</th>
  	  	  </tr>
		  	  	  <tr ng-if="sale.sale_type == 'apartado' && commission_type == 'sale_payments' " >
		  	  	  	<th colspan="5" class="text-center">Abonos</th>
		  	  	  </tr>
		  	  	  <tr ng-if="sale.sale_type == 'apartado' && commission_type == 'sale_payments' ">
		  	  	  	<th></th>
		  	  	  	<th>Número</th>
		  	  	  	<th>Cantidad</th>
		  	  	  	<th>Vendedor que recibio</th>
		  	  	  	<th>Fecha</th>
		  	  	  </tr>
		  	  	  <tr ng-repeat="(k ,sale_payment) in sale.sale_payments"  ng-if="sale.sale_type == 'apartado' && commission_type == 'sale_payments' ">
		  	  	  	<td><?php echo Form::checkbox('SalePayments[{{ sale_payment.id }}][]' , '1' , false , ['ng-model' => 'sale.sale_payments[k].in_commission' ,'ng-change' => 'getTotals()'] ); ?></td>
		  	  	  	<td>@{{ k+1 }}</td>
		  	  	  	<td>@{{ sale_payment.quantity | currency }}</td>
		  	  	  	<td>@{{ sale_payment.employee.user.name }}</td>
		  	  	  	<td>@{{ sale_payment.created_at }}</td>
		  	  	  </tr>
  	  	  <tr>
  	  	  	<th  colspan="4" class="text-right">Cantidad total sobre la que se aplicara la comisión:</th>
  	  	  	<th >@{{ total_commission | currency }}</th>
  	  	  </tr>
  	  	  <tr ng-if="error_total_commission">
  	  	  	<td colspan="4" class="text-right">
  	  	  		<p class="error_message"  >@{{ error_total_commission }}</p>
  	  	  	</td>
  	  	  	<th></th>
  	  	  </tr>
  	  	  </table>

  	      <div class="clearfix"></div>



  	      <div class="col-md-6 col-sm-6" >



			</div>


          <div class="form-group col-md-12 col-sm-12 " >

  	  			@include('commissions/fields/employee_id_edit')

  	      </div>

          <div class="form-group col-md-4 col-sm-6" >

            @include('commissions/fields/percent')

          </div>

          <div class="form-group col-md-4 col-sm-6" >

            @include('commissions/fields/status_pay')

          </div>

          <div class="form-group col-md-4 col-sm-6" >

            @include('commissions/fields/date')

          </div>

          <div class"form-group col-md-6 col-sm-6">
          	<label></label>
          	<h4>Total de comisión: <span>@{{ total | currency }}</span></h4>
          </div>




  	  	  	<?php echo Form::hidden('sale_id' , '{{ commission.sale_id }}'); ?> <?php echo Form::hidden('Commissions[{{k}}][employee_id]' , '{{ commission.employee_id }}'); ?></td>
  	  	  	<?php echo Form::hidden('type' , '{{ commission_type }}'); ?></td>
  	  	  	<?php echo Form::hidden('total_commission' , '{{ total_commission }}'); ?></td>
  	  	  	<?php echo Form::hidden('percent' , '{{ percent }}'); ?></td>
  	  	  	<?php echo Form::hidden('total' , '{{ total }}'); ?></td>
  	  	  	<div ng-repeat="sale_payment in sale.sale_payments">
  	  	  		<?php echo Form::hidden('SalePayment[]' , '{{ sale_payment.id }}', ['ng-if' => 'sale_payment.in_commission']); ?>
  	  	  	</div>

          <div class="form-group col-md-12 ">

            <button type="submit" class="btn btn-success pull-right">Actualizar</button>

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
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/js/bootstrap-switch.js' ,
            'library/js/jquery.tagsinput.js' ,
            'library/js/ga.js' ,
            'library/js/ng/date.format.js',
            'library/js/ng/commissions.js',
            'library/js/ng/commissions.controllers.js',
            'library/js/ng/commissions.services.js',
            'library/js/ng/commissions.filters.js',
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
        ]
    ]
)

@stop