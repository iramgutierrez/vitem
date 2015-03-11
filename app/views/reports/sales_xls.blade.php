
<table  class="display table table-bordered table-striped" id="dynamic-table" >
	<thead>
		<tr >
			<th>Contador</th>
			<th>ID</th>
			<th>Folio</th>
			<th>Empleado</th>
			<th>Cliente</th>
			<th>Fecha de venta</th>
			<th>Tipo de venta</th>
			<th>Forma de pago</th>						
			<th>Total</th>				
			<th>Productos</th>					
			<th>Paquetes</th>				
			<th>Comisiones</th>			
			<th>Entrega</th>
	  </tr>      
	</thead>
	<tbody>
		@foreach($sales as $k => $sale)
		<tr class="gradeX" >
			<td>{{ $k + 1 }}</td>
			<td>{{ $sale->id }}</td>
			<td>{{ $sale->sheet }}</td>
			<td>{{ $sale->employee->user->name }}</td>
			<td>{{ $sale->client->name }}</td>
			<td>{{ $sale->sale_date }}</td>
			<td>{{ $sale->sale_type }}</td>
			<td>{{ $sale->pay_type }}</td>
			<td>{{ $sale->total}}</td>
			<td>
				@if(count($sale->products))
				<table>
					<tr>
						<th>Producto</th>
						<th>Cantidad</th>
					</tr>
					@foreach($sale->products as $product)
					<tr>
						<td>{{$product->name}}</td>
						<td>{{$product->pivot->quantity}}</td>
					</tr>
					@endforeach
				</table>
				@endif
			</td>
			<td>
				@if(count($sale->packs))
				<table>
					<tr>
						<th>Producto</th>
						<th>Cantidad</th>
					</tr>
					@foreach($sale->packs as $pack)
					<tr>
						<td>{{$pack->name}}</td>
						<td>{{$pack->pivot->quantity}}</td>
					</tr>
					@endforeach
				</table>
				@endif
			</td>
			<td>
				@if(count($sale->commissions))
				<table >
					<tr>
						<th>Empleado</th>
						<th>Comisión</th>
					</tr>
					@foreach($sale->commissions as $commission)
					<tr>
						<td>{{$commission->employee->user->name}}</td>
						<td>{{$commission->total}}</td>
					</tr>
					@endforeach
				</table>
				@endif
			</td>
			<td>
				@if(isset($sale->delivery->destination))
				<table>
					<tr>
						<th>Direccion</th>
						<th>Destino</th>
						<th>Chofer</th>
					</tr>
					<tr>
						<td>{{$sale->delivery->address}}</td>
						<td>{{$sale->delivery->destination->type }}: {{$sale->delivery->destination->value_type}}</td>
						<td>{{$sale->delivery->employee->user->name}}</td>
					</tr>
				</table>
				@endif
			</td>
		</tr>  
		@endforeach            
	</tbody>
</table> 