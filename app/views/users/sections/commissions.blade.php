<section class="panel" ng-show="tab == 'comisiones' " ng-if="$root.auth_permissions.read.commission" >

	<div class="panel-heading">
		<h3>Comisiones. </h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-condensed">

			@if(count($user->employee->commissions))
				<tr>
					<th class="col-sm-2 col-md-2" >Total sobre el que se aplico la comisión</th>
					<th class="col-sm-1 col-md-1"  class="col-sm-2 col-md-2" >Porcentaje</th>
					<th class="col-sm-1 col-md-1" >Comisión</th>
					<th class="col-sm-2 col-md-2" >Empleado que recibio la comisión</th>
					<th class="col-sm-2 col-md-2" >Tipo</th>
					<th class="col-sm-2 col-md-2" >Fecha</th>
					<th class="col-sm-2 col-md-2" ></th>
				</tr>
				@foreach($user->employee->commissions as $commission )
					<tr>
						<td>{{ '<?php echo $commission->total_commission; ?>' | currency }}</td>
						<td>{{ $commission->percent }} %</td>
						<td>{{ '<?php echo $commission->total; ?>' | currency }}</td>
						<td>{{ $commission->employee->user->name }}</td>
						<td>{{ '<?php echo $commission->type ?>' | commission_types }}</td>
						<td>{{ $commission->date }}</td>
						<td>
							<a href="{{ $commission->url_edit }}" ng-if="$root.auth_permissions.update.commission"  >
								<button  type="button" class="col-sm-5 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
							</a>
							<a data-toggle="modal" href="#myModal{{ $commission->id }}" ng-if="$root.auth_permissions.delete.commission" >
								<button type="button" class="col-sm-5 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
							</a>
						</td>
					</tr>



				@endforeach

			@endif

		</table>

		@if(count($user->employee->commissions))

			@foreach($user->employee->commissions as $commission )

				<div class="modal fade" id="myModal{{ $commission->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Confirma</h4>
							</div>
							<div class="modal-body">

								¿Deseas eliminar esta comisión?

							</div>
							<div class="modal-footer">
								<form class="btn " method="POST"  action="{{ $commission->url_delete }}">
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