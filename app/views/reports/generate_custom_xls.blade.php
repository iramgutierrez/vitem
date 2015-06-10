
<table  class="display table table-bordered table-striped" id="dynamic-table" >
	<thead>
		<tr>
			@foreach($headersXLS as $header)
				<th>{{ $header['label'] }}</th>
			@endforeach
			
	  	</tr>      
	</thead>
	<tbody>

		@foreach($dataXLS as $record)
		<tr>
			@foreach($record as $field)
				<td> {{ $field }}</td>

			@endforeach

		</tr>

		@endforeach
		
	</tbody>
</table> 