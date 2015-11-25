
	<div class="col-sm-6">
        <label for="segments" class="col-xs-9">Criterios de segmentación.</label>
        <a class="col-sm-3 pul-right" data-toggle="modal" href="#addSegment">Nuevo</a>
    </div>
    <div class="col-sm-12"></div>
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
			<th>Criterio</th>
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

<div ng-show="$root.auth_permissions.create.segment" class="modal fade" id="addSegment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar elemento al catálogo de @{{ catalog.name }}</h4>
            </div>

            <div class="modal-body">

                <div>

                    <div class="col-md-12 col-sm-12">

                        <table class="display table table-bordered table-striped col-sm-12">
                            <tbody>
                            <tr ng-repeat="(i , item) in CatalogItem">
                                <td class="col-sm-5">@{{ item.catalog.name }}</td>
                                <td class="col-sm-5">
                                    @{{ item.item.name }}
                                    <input type="hidden" name="CatalogItem[]" ng-model="item.item.id" ng-value="item.item.id" />
                                </td>
                                <td class="col-sm-2 text-center">
                                    <a href="" ng-click="removeCatalogItem(i,item)">
                                <span class="badge bg-important">
                                    <i class="fa fa-times"></i>
                                </span>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class=" form-group col-md-4 col-sm-12">
                            {{ Field::select(
                                   'catalog',
                                   [],
                                   '' ,
                                   [
                                       'ng-model' => 'catalog',
                                       'ng-options' => 'c as c.name for c in catalogs',
                                       'ng-change' => 'getCatalogItems()'

                                   ]
                               )
                            }}
                        </div>

                        <div class=" form-group col-md-4 col-sm-12">
                            {{ Field::select(
                                   'catalog_item',
                                   [],
                                   '' ,
                                   [
                                       'ng-model' => 'item',
                                       'ng-options' => 'i as i.name for i in items'

                                   ]
                               )
                            }}
                        </div>

                        <div class="form-group col-sm-4 col-sm-12">

                            <?php echo Field::number(
                                   'segment_quantity',
                                   '' ,
                                   [
                                       'ng-model' => 'quantity_segment',
                                       'min' => '0',
                                       'max' => '{{ calculateMax() }}',
                                       'ng-init' => 'calculateMin()'

                                   ]
                               )
                            ?>

                        </div>

                        <button type="button" class="btn btn-success pull-right" ng-click="addCatalogItem()" ng-disabled="!item || !catalog">Agregar</button>

                    </div>
                </div>

            </div>


            <div class="modal-footer">
                <div class="col-sm-12">
                    <br/>
                    <button data-dismiss="modal" class="btn btn-default close_modal" type="button">Cancelar</button>

                    <button type="button" ng-click="newSegment()" class="btn btn-success" data-ng-disabled="!quantity_segment || !CatalogItem.length">Guardar</button>

                </div>
            </div>

        </div>
    </div>
</div>


