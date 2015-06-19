
	<label for="colors" class="col-xs-12">Agregar color</label>
	@if(isset($product))
		<div class="col-xs-6" ng-init="initColors({{ $product->id }})">
	@else
		<div class="col-xs-6" ng-init="initColors()">
	@endif
		<select class="form-control" name="colors" ng-model="selectColors" >
			
			<option value="@{{ color.id }}"  ng-repeat="color in allColors | orderBy:'name'"" ng-selected="color.id == selectColors">@{{ color.name }}</option>
		</select>
	</div>


	<div class="col-sm-3 col-xs-6 ">
		<input type="number" min="0" max="@{{ calculateMax() }}" name="color_quantity" class="form-control" ng-init="calculateMin()" ng-model="quantity_color">
	</div>
	<button class="col-xs-3 pull-right btn btn-primary" type="button" ng-click="addColor()" ng-disabled="validAddColor();">
		Agregar
	</button>

	<table class="table stripped" ng-show="colors.length">
		<tr>
			<th>Color</th>
			<th>Cantidad</th>
			<th></th>
		</tr>		
		<tr ng-repeat="(k ,color) in colors | orderBy : 'name' ">
			<td>
				@{{ color.name }} 
			<td>
				@{{ color.quantity }}
				<input type="hidden" name="ColorProduct[@{{ color.id }}][quantity]" value="@{{ color.quantity }}" />
			</td>

			<td>
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-info " ng-click="updateColor(color)"><i class="fa fa-refresh"></i></button>

				{{--<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger" ng-click="removeColor(color)"><i class="fa fa-trash-o"></i></button>--}}
			</td>
		</tr>
	</table>