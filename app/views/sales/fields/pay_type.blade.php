<div class="col-sm-12">

	<label for="pay_type">Forma de pago</label>

	<select class="form-control" name="pay_type_id" ng-model="pay_type_id" ng-init="pay_type_id = checkValuePreOrOld('{{ ((!empty($sale->pay_type_id)) ? $sale->pay_type_id : '') }}' , '{{((Input::old('pay_type_id')) ? Input::old('pay_type_id') : '')}}') " ng-change="calculteCommissionPay();">
		<option value="" selected="selected">Seleccione</option>

		<option value="@{{ type.id }}" ng-selected="pay_type_id == type.id" ng-repeat="type in pay_types">@{{ type.name }}</option>

	</select>


</div>