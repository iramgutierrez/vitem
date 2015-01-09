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

	{{ Form::model( new Commission ,['route' => 'commissions.store',  'name' => 'addCommissionsForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Nueva comisión</h1>

  	  	</header>

  	  	<div class="panel-body" >    	  	  

  	  	  <div class="col-md-6 col-sm-6" >

  	  			@include('commissions/fields/sheet_sale')  	  			  

  	      </div>  

          <div ng-show="sale_id">

    	  	  <h4 class="col-sm-12">Tipo de venta: <span> @{{ sale.sale_type }}</span></h4>

    	  	  <div class="col-sm-12" ng-show="sale.sale_type == 'apartado'">
  	  	  	  
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
  		  	  	  	<td><?php echo Form::checkbox('SalePayments[{{ sale_payment.id }}][]' , '1' , false , ['ng-model' => 'sale.sale_payments[k].in_commission' , 'ng-change' => 'getTotals()'] ); ?></td>
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

    	  			@include('commissions/fields/employee_id')

    	      </div> 

            <div class="form-group col-md-6 col-sm-6" >

              @include('commissions/fields/percent')

            </div>

            <div class"form-group col-md-6 col-sm-6">
            	<label></label>
            	<h4>Total de comisión: <span>@{{ total | currency }}</span></h4>
            </div>

            <div class="form-group col-md-12 ">                              
        
              <button type="button" class="btn btn-success pull-right" ng-click="addCommission()" >Agregar comisión</button>
      
            </div>


            <table class="table table-bordered table-striped table-condensed" ng-show="commissions.length > 0">

    	  	  	<tr>

    	  	  		<th>Número</th>
    	  	  		<th>Vendedor</th>
    	  	  		<th>Tipo de comisión</th>
    	  	  		<th>Cantidad Total</th>
    	  	  		<th>Porcentaje de comisión</th>
    	  	  		<th>Total</th>
    	  	  		<th>Eliminar</th>

    	  	  	</tr>

    	  	  	<tr ng-repeat="(k , commission) in commissions">
    	  	  		<td>@{{k+1 }}</td>
    	  	  		<td>@{{ commission.employee_name }} <?php echo Form::hidden('Commissions[{{k}}][sale_id]' , '{{ sale_id }}'); ?> <?php echo Form::hidden('Commissions[{{k}}][employee_id]' , '{{ commission.employee_id }}'); ?></td>
    	  	  		<td>@{{ commission.type }} <?php echo Form::hidden('Commissions[{{k}}][type]' , '{{ commission.type }}'); ?></td>
    	  	  		<td>@{{ commission.total_commission | currency }} <?php echo Form::hidden('Commissions[{{k}}][total_commission]' , '{{ commission.total_commission }}'); ?></td>
    	  	  		<td>@{{ commission.percent }} <?php echo Form::hidden('Commissions[{{k}}][percent]' , '{{ commission.percent }}'); ?></td>
    	  	  		<td>@{{ commission.total | currency }} <?php echo Form::hidden('Commissions[{{k}}][total]' , '{{ commission.total }}'); ?></td>
    	  	  		<td>
    	  	  			<div ng-repeat="(ks , sale_payments) in commission.SalePayments">
    	  	  				<?php echo Form::hidden('Commissions[{{k}}][SalePayment][]' , '{{ ks }}'); ?>  	  	  			
    	  	  			</div>
  					<button ng-click="deleteCommission(k)" type="button" class="col-sm-12 btn btn-danger"><i class="fa fa-trash-o"></i></button>   
  					
    	  	  		</td>
    	  	  	</tr>

    	  	  </table>


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
        'library/js/ng/commissions.js',
        'library/js/ng/commissions.controllers.js',
        'library/js/ng/commissions.services.js',
        'library/js/ng/sales.services.js',
        'library/js/ng/users.services.js',
        'library/js/ng/users.filters.js',
        'library/js/jquery-ui-1.9.2.custom.min.js' ,
        'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop