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

	{{ Form::model( new Commission ,['route' => 'commissions.store',  'name' => 'addCommissionsForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'CreateManyController'  ]) }}

  	<div class="panel">

  	  	<header class="panel-heading">

  	    	<h1>Agregar comisiones</h1>

  	  	</header>

  	  	<div class="panel-body" >

          <div ng-show="error" class="col-sm-12" >
            <h2 class="text-center error">@{{ error }}</h2>
          </div>
          <div class="form-group col-md-12 col-sm-12 " >

            @include('commissions/fields/employee_id')

          </div>

          <legend class="text-center">o</legend>

          <div class="form-group col-md-12 col-sm-12" >
            <input type="checkbox" name="self_seller" id="self_seller" ng-model="self_seller" />
            <label for="self_seller">Asignar al vendedor correspondiente (Quien realizo la venta).</label>
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

          <div class="form-group col-md-12 ">

            <button type="button" class="btn btn-success pull-right" ng-click="addCommissions()" >Agregar</button>

          </div>

          <div class="col-sm-12">




            <table class="table table-bordered table-striped table-condensed">

    	  	  	<tr>

    	  	  		<th>Folio</th>
    	  	  		<th>Vendedor</th>
                <th>Tipo de venta</th>
    	  	  		<th>Fecha</th>
    	  	  		<th>Total</th>

    	  	  	</tr>
              @foreach($sales as $sale)
    	  	  	<tr ng-init="sales.push({
                id : '<?php echo $sale->id; ?>',
                employee_id : '<?php echo $sale->employee_id; ?>',
                employee_name : '<?php echo $sale->employee->user->name; ?>',
                total : '<?php echo $sale->total; ?>'
              })">
    	  	  		<td>{{ $sale->sheet }}</td>
    	  	  		<td>{{ $sale->employee->user->name }} </td>
    	  	  		<td>{{ $sale->sale_type }} </td>
    	  	  		<td>{{ $sale->sale_date }} </td>
                <td>{{  "<?php echo $sale->total; ?>" | currency }} </td>
    	  	  	</tr>
              @endforeach

    	  	  </table>


            <div class="form-group col-md-12 ">

              <table class="table table-bordered table-striped table-condensed" ng-show="commissions.length > 0">

                <tr>

                  <th>Número</th>
                  <th>Vendedor</th>
                  <th>Tipo de comisión</th>
                  <th>Cantidad Total</th>
                  <th>Porcentaje de comisión</th>
                  <th>Estatus de pago</th>
                  <th>Fecha</th>
                  <th>Total</th>
                  <th>Eliminar</th>

                </tr>

                <tr ng-repeat="(k , commission) in commissions">
                  <td>@{{k+1 }}</td>
                  <td>@{{ commission.employee_name }} <?php echo Form::hidden('Commissions[{{k}}][sale_id]' , '{{ commission.sale_id }}'); ?> <?php echo Form::hidden('Commissions[{{k}}][employee_id]' , '{{ commission.employee_id }}'); ?></td>
                  <td>@{{ commission.type }} <?php echo Form::hidden('Commissions[{{k}}][type]' , '{{ commission.type }}'); ?></td>
                  <td>@{{ commission.total_commission | currency }} <?php echo Form::hidden('Commissions[{{k}}][total_commission]' , '{{ commission.total_commission }}'); ?></td>
                  <td>@{{ commission.percent }} <?php echo Form::hidden('Commissions[{{k}}][percent]' , '{{ commission.percent }}'); ?></td>
                  <td>@{{ commission.status_pay }} <?php echo Form::hidden('Commissions[{{k}}][status_pay]' , '{{ commission.status_pay }}'); ?></td>
                  <td>@{{ commission.date }} <?php echo Form::hidden('Commissions[{{k}}][date]' , '{{ commission.date }}'); ?></td>
                  <td>@{{ commission.total | currency }} <?php echo Form::hidden('Commissions[{{k}}][total]' , '{{ commission.total }}'); ?></td>
                  <td>
              <button ng-click="deleteCommission(k)" type="button" class="col-sm-12 btn btn-danger"><i class="fa fa-trash-o"></i></button>

                  </td>
                </tr>

              </table>

              <button type="submit" class="btn btn-success pull-right" ng-disabled="!(commissions.length > 0)">Registrar</button>

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