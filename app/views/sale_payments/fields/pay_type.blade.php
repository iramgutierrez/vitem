<div class="col-sm-12">

	<label for="pay_type">Forma de pago</label>

	<select class="form-control" name="pay_type_id" ng-model="pay_type_id" ng-value="pay_type_id" ng-init="pay_type_id = checkValuePreOrOld({{((!empty($sale_payment->pay_type_id)) ? $sale_payment->pay_type_id : '')}} , '{{ ((Input::old('pay_type_id')) ? Input::old('pay_type_id') : '') }}')" >

		<option value="" selected="selected">Seleccione</option>

		<option value="@{{ type.id }}" ng-selected="type.id == checkValuePreOrOld({{((!empty($sale_payment->pay_type_id)) ? $sale_payment->pay_type_id : '')}} , '{{ ((Input::old('pay_type_id')) ? Input::old('pay_type_id') : '') }}')" ng-repeat="type in pay_types">@{{ type.name }}</option>

	</select>

</div>