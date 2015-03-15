<section class="panel" >
		                      	<div class="panel-heading">
		                      		<h3>Entregas. </h3>
		                      		@if(!empty($sale->delivery))

		                      			<a ng-if="$root.auth_permissions.update.delivery" href="{{ route('deliveries.edit' , [ $sale->delivery->id ] ) }}" ><button type="button" class="pull-right btn btn-success "> Editar entrega</button></a><br>
		                      				                      		
	                      			@else	

		                      			<a ng-if="$root.auth_permissions.create.delivery" href="{{ route('deliveries.create.sale_id' , [ $sale->id ] ) }}" ><button type="button" class="pull-right btn btn-success "> Agregar entrega</button></a><br>
		                      				                      		
	                      			@endif		     
		                      	</div>
		                      	<div class="panel-body">	
		                      		<table class="table table-bordered table-striped table-condensed">

		                      		@if(!empty($sale->delivery))
		                      			<tr>
		                      				<th class="col-sm-2 col-md-2" >id</th>
		                      				<th class="col-sm-1 col-md-1"  class="col-sm-2 col-md-2" >Dirección</th>
		                      				@if(!empty($sale->delivery->destination))
		                      				<th class="col-sm-1 col-md-1" >Destino</th>
		                      				<th class="col-sm-2 col-md-2" >Costo</th>
		                      				@endif
		                      				<th class="col-sm-2 col-md-2" >Chofer</th>
		                      				<th class="col-sm-2 col-md-2" >Fecha de entrega</th>
		                      				<th class="col-sm-2 col-md-2" ></th>
		                      			</tr>
		                      			<tr>
		                      				<td>{{ $sale->delivery->id }}</td>
		                      				<td>{{ $sale->delivery->address }}</td>
		                      				@if(!empty($sale->delivery->destination))
		                      				<td>{{ $sale->delivery->destination->zip_code.' '.$sale->delivery->destination->colony.' '.$sale->delivery->destination->town.' '.$sale->delivery->destination->state }}</td>
		                      				<td>{{ '<?php echo $sale->delivery->destination->cost ?>' | currency }}</td>
		                      				@endif
		                      				<td>{{ $sale->delivery->employee->user->name }}</td>
		                      				<td>{{ $sale->delivery->delivery_date }}</td>
		                      				<td>		                      					
												<a ng-if="$root.auth_permissions.update.delivery" href="{{ $sale->delivery->url_edit }}" >
													<button  type="button" class="col-sm-5 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
												</a>
												<a  ng-if="$root.auth_permissions.delete.delivery"data-toggle="modal" href="#myModal{{ $sale->delivery->id }}" >
													<button type="button" class="col-sm-5 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
												</a>
		                      				</td>
		                      			</tr>                      			
		                      				                      		
	                      			@endif		                      			

		                      		</table>	

		                      		@if(!empty($sale->delivery))

		                      			<div ng-if="$root.auth_permissions.update.delivery" class="modal fade" id="myModal{{ $sale->delivery->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title">Confirma</h4>
													</div>
													<div class="modal-body">

														¿Deseas eliminar esta entrega?

													</div>
													<div class="modal-footer">                                        
														<form class="btn " method="POST"  action="{{ $sale->delivery->url_delete }}">
															<input name="_method" type="hidden" value="DELETE" />
															{{  Form::token() }}															
															<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>      
															<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i>Confirmar</button>    
														</form>
													</div>
												</div>
											</div>
										</div>

									@endif

		                      	</div>

		                      </section>