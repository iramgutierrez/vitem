<section class="panel" ng-show="tab == 'entregas' " ng-if="$root.auth_permissions.read.delivery && $root.user_permissions.create.delivery" >

	<div class="panel-heading">
		<h3>Entregas. </h3>
	</div>
	<div class="panel-body">

		<table class="table table-bordered table-striped table-condensed">

			@if(count($user->employee->deliveries))
				<tr>
					<th class="col-sm-2 col-md-2" >Id</th>
					<th class="col-sm-1 col-md-1"  class="col-sm-2 col-md-2" >Destino</th>
					<th class="col-sm-1 col-md-1" >Folio de venta</th>
					<th class="col-sm-2 col-md-2" >Dirección</th>
					<th class="col-sm-2 col-md-2" >Fecha de entrega</th>
					<th class="col-sm-2 col-md-2" ></th>
				</tr>
				@foreach($user->employee->deliveries as $delivery )
					<tr>
						<td>{{ $delivery->id }}</td>
						<td>{{ $delivery->destination['value_type'] }} </td>
						<td>{{ $delivery->sale->sheet }}</td>
						<td>{{ $delivery->address }}</td>
						<td>{{ $delivery->delivery_date }}</td>
						<td>
							<a href="{{ $delivery->url_edit }}" ng-if="$root.auth_permissions.update.delivery"  >
								<button  type="button" class="col-sm-5 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
							</a>
							<a data-toggle="modal" href="#myModal{{ $delivery->id }}" ng-if="$root.auth_permissions.delete.delivery" >
								<button type="button" class="col-sm-5 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
							</a>
						</td>
					</tr>

				@endforeach

			@endif

		</table>

		@if(count($user->employee->deliveries))

			@foreach($user->employee->deliveries as $delivery )

				<div class="modal fade" id="myModal{{ $delivery->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Confirma</h4>
							</div>
							<div class="modal-body">

								¿Deseas eliminar la entrega?

							</div>
							<div class="modal-footer">
								<form class="btn " method="POST"  action="{{ $delivery->url_delete }}">
									<input name="_method" type="hidden" value="DELETE" />
									{{  Form::token() }}
									<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i>Confirmar</button>
								</form>
							</div>
						</div>
					</div>
				</div>

			@endforeach

		@endif

	</div>

</section>