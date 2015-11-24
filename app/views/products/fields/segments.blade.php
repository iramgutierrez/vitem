
	<label for="segments" class="col-xs-12">Agregar segmento</label>
	@if(isset($product) && !Input::old('SegmentProduct'))
		<div class="col-xs-6" ng-init="initSegments({{ $product->id }})">
	@else
		<div class="col-xs-6" ng-init="initSegments()">
	@endif
		<select class="form-control" name="segments" ng-model="selectSegments" >

			<option value="@{{ segment.id }}"  ng-repeat="segment in allSegments | orderBy:'name'"" ng-selected="segment.id == selectSegments">@{{ segment.name }}</option>
		</select>
	</div>


	<div class="col-sm-3 col-xs-6 ">
		<input type="number" min="0" max="@{{ calculateMax() }}" name="segment_quantity" class="form-control" ng-init="calculateMin()" ng-model="quantity_segment">
	</div>
	<button class="col-xs-3 pull-right btn btn-primary" type="button" ng-click="addSegment()" ng-disabled="validAddSegment();">
		Agregar
	</button>

	<table class="table stripped" >
		<tr>
			<th>Criterio de segmentación</th>
			<th>Cantidad</th>
			<th></th>
		</tr>
		<tr ng-show="notSegment">
			<td>@{{ notSegment.name }}</td>
			<td>
				@{{ calculateNotAssigned() }}
				<input type="hidden" name="SegmentProduct[@{{ notSegment.id }}][quantity]" value="@{{ calculateMax() }}" />
			</td>
		</tr>
		<tr ng-repeat="(k ,segment) in segments | orderBy : 'name' ">
			<td>
				@{{ segment.name }}
			<td>
				@{{ segment.quantity }}
				<input type="hidden" name="SegmentProduct[@{{ segment.id }}][quantity]" value="@{{ segment.quantity }}" />
			</td>

			<td>
				<button type="button" class="col-sm-6 col-sm-offset-1 btn btn-info " ng-click="updateSegment(segment)"><i class="fa fa-refresh"></i></button>

				{{--<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger" ng-click="removeSegment(segment)"><i class="fa fa-trash-o"></i></button>--}}
			</td>
		</tr>
	</table>