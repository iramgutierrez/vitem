<div class="col-sm-12">

	<table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >

		<thead>

			<tr>
				<th class="col-sm-2" ></th>
				<th class="col-sm-5" ng-repeat="driver in driversCompare">
					@{{ driver.user.name }}
				</th>
			</tr>

		</thead>

		<tbody>
			<tr ng-repeat="field in fields">
				<th>@{{ field.label }}</th>

				<td ng-repeat="data in field.data">

					@{{ data.count }}

				</td>

			</tr>
		</tbody>

	</table>

</div>