
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
			<th>Cantidad pagado</th>
			<th>Porcentaje pagado</th>
			<th>Forma de pago</th>
			<th>Total de venta</th>
			<th>Comisión a forma de pago</th>
			<th>Total en caja</th>
			<th>Productos</th>
            <th>Paquetes</th>
			{{--<th>Paquetes</th>--}}
			<th>Comisiones</th>
			<th>Entrega</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($sales as $k => $sale)
		<tr class="gradeX" >
			<td>{{ $k + 1 }}</td>
			<td>@if(!empty($sale->id)) {{ $sale->id }} @endif </td>
			<td>@if(!empty($sale->sheet)) {{ $sale->sheet }} @endif </td>
			<td>@if(!empty($sale->employee->user->name)) {{ $sale->employee->user->name }} @endif </td>
			<td>@if(!empty($sale->client->name)) {{ $sale->client->name }} @endif </td>
			<td>@if(!empty($sale->sale_date)) {{ $sale->sale_date }} @endif </td>
			<td>@if(!empty($sale->sale_type)) {{ $sale->sale_type }} @endif </td>
			<td>@if(!empty($sale->cleared_payment)) {{ number_format($sale->cleared_payment, 2) }} @endif </td>
			<td>@if(!empty($sale->percent_cleared_payment)) {{ $sale->percent_cleared_payment }} @endif </td>
			<td>@if(!empty($sale->pay_type->name)) {{ $sale->pay_type->name }} @endif </td>
			<td>@if(!empty($sale->subtotal)) {{ number_format($sale->subtotal, 2) }} @endif </td>
			<td>@if(!empty($sale->commission_pay)) {{ number_format($sale->commission_pay, 2) }} @endif </td>
			<td>@if(!empty($sale->total)) {{ number_format($sale->total, 2) }} @endif </td>
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
						<th>Paquete</th>
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