<div class="col-sm-12" ng-init="
@if(Input::old('ProductSale'))
  @foreach(Input::old('ProductSale') as $k => $p)
            productsOld.push({
              product_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}'
            });
  @endforeach
  getProductsOld();
@endif

@if(Input::old('PackSale'))
  @foreach(Input::old('PackSale') as $k => $p)
            packsOld.push({
              pack_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}'
            });
  @endforeach
  getPacksOld();
@endif

" >

  <table class="table table-bordered table-striped table-condensed" >

    <thead>

        <tr>

        <th>Id</th>

        <th>Nombre</th>

        <th>Tipo</th>

        <th>Código</th>

        <th>Modelo / Descripción</th>

        <th>En existencia</th>

        <th>Precio Unitario</th>

        <th>Descuento</th>

        <th>Cantidad</th>

        <th>Precio</th>

        <th>Precio con descuento</th>

        <th>Borrar</th>

      </tr>

      </thead>

      <tbody ng-repeat="(k , product) in $root.productsSelected track by k">

      	<tr ng-class="{ quantity_null : product.quantity_null  }" ng-hide="product.pack_id && !showPacksSelected[product.pack_id].visible">

  	    	<td class="col-sm-1" >

  	        	@{{product.id }}

  	      	</td>

  	      	<td class="col-sm-1"> @{{product.name }}</td>

  	      	<td class="col-sm-1"> Producto </td>

  	      	<td class="col-sm-1"> @{{product.key }}</td>

  		    <td class="col-sm-1"> @{{product.model }}</td>

  		    <td class="col-sm-1"> @{{ product.stock }}</td>

  		    <td class="col-sm-1"> @{{product.price | currency }}</td>

            <td class="col-sm-1">
                <span ng-show="!product.pack_id" >@{{ product.discount.name }}</span>
            </td>

  		    <td class="col-sm-1">

          		<div id="spinner1 col-sm-2">

                    <div class="input-group input-small">



                        <input ng-if="!product.pack_id && !product.isPack" type="text" class="spinner-input form-control" maxlength="3" ng-model="product.quantity" name="ProductSale[@{{ k }}][quantity]" >
                        <input ng-if="!product.pack_id && !product.isPack" type="hidden" ng-model="product.discount.id"  ng-value="product.discount.id" name="ProductSale[@{{ k }}][discount_id]" >
                        <input ng-if="!product.pack_id && !product.isPack" type="hidden" ng-model="product.id"  ng-value="product.id" name="ProductSale[@{{ k }}][product_id]" >

                        <input ng-if="!product.pack_id && product.isPack" type="text" class="spinner-input form-control" maxlength="3" ng-model="product.quantity" name="PackSale[@{{ product.id }}][quantity]" >
                        <input ng-if="!product.pack_id && product.isPack" type="hidden" ng-model="product.discount.id"  ng-value="product.discount.id" name="PackSale[@{{ product.id }}][discount_id]" >

                        <input ng-disabled="product.pack_id" ng-if="product.pack_id" type="text" class="spinner-input form-control" maxlength="3" ng-model="showPacksSelected[product.pack_id].products[product.id].quantityTotal">

                        <div class="spinner-buttons input-group-btn btn-group-vertical" ng-show="!product.pack_id">

                          <button ng-click= "product.quantity =  addQuantity(product.quantity);  addQuantityPack(product.quantity , product.id); checkDiscount(product , k)" type="button" class="btn spinner-up btn-xs btn-default">

                              <i class="fa fa-angle-up"></i>

                            </button>

                            <button ng-click= "product.quantity = removeQuantity(product.quantity); checkDiscount(product , k)" type="button" class="btn spinner-down btn-xs btn-default">

                              <i class="fa fa-angle-down"></i>

                            </button>

                        </div>

                    </div>

                  </div>

                <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="showSegments(product); " ng-show="!product.showSegments && !product.isPack" >Mostrar segmentos</button>

                <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="showSegments(product); " ng-show="product.showSegments && !product.isPack" >Ocultar segmentos</button>

                <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="changeShowPackSelected(product.id);" ng-show="product.isPack && !showPacksSelected[product.id].visible" >Mostrar detalle</button>

                <button type="button" class="btn btn-primary col-sm-12" style="margin-top: 10px" ng-click="changeShowPackSelected(product.id);" ng-show="product.isPack && showPacksSelected[product.id].visible" >Ocultar detalle</button>

        		</td>

        		<td class="col-sm-1">
                    <span ng-show="!product.pack_id" >@{{ pricePerQuantity(product.price , product.quantity) | currency  }}</span>
                </td>

                <td class="col-sm-1">
                    <span ng-show="!product.pack_id" >@{{ priceDiscountPerQuantity(product.discount , pricePerQuantity(product.price , product.quantity) , product.quantity) | currency  }}</span>
                </td>

        		<td class="col-sm-1">

  		    	<button type="button" class="col-sm-12 btn btn-danger" ng-click="removeProduct(k)" >

  		          <i class="fa fa-times"></i>

  		        </button>

  		    </td>

      	</tr>

        <tr ng-if="product.showSegments && product.segments.length">
          <td colspan="5"></td>
          <td>Segment</td>
          <td>Disponibles</td>
          <td>Asignados</td>
          <td></td>
          <td></td>
        </tr>

        <tr ng-if="product.showSegments && !product.segments.length">
          <td colspan="8" class="text-right">Este producto no tiene segmentos asignados</td>
          <td></td>
          <td></td>
        </tr>

        <tr ng-if="product.showSegments && product.segments.length">
          <td colspan="6" class="text-right">
            Ningun criterio de segmentación asignado
          </td>
          <td>
            @{{ product.notSegment.pivot.quantity }}
                <input type="hidden" ng-if="!product.pack_id && !product.isPack" name="SegmentProductSale[@{{ k  }}_][quantity]" value="@{{ getProductsWithoutSegments(product) }}">
                <input type="hidden" ng-if="!product.pack_id && !product.isPack" name="SegmentProductSale[@{{ k  }}_][segment_product]" value="@{{ product.notSegment.pivot.id }}">

                <input type="hidden" ng-if="product.pack_id && !product.isPack" name="SegmentProductPackSale[@{{product.notSegment.pivot.id}}][quantity]" value="@{{ getProductsWithoutSegments(product) }}">
                <input type="hidden" ng-if="product.pack_id && !product.isPack" name="SegmentProductPackSale[@{{product.notSegment.pivot.id}}][pack_id]" value="@{{ product.pack_id }}">
          </td>
          <td>@{{ getProductsWithoutSegments(product) }}</td>
          <td></td>
          <td></td>
        </tr>

        <tr  ng-show="product.showSegments && product.segments.length" ng-repeat="(c , segment)  in product.segments">
          <td colspan="5"></td>
          <td>@{{ segment.name }}</td>
          <td>@{{ segment.pivot.quantity }}</td>
          <td>
              <input type="number" ng-if="!product.pack_id && !product.isPack" class="form-control" ng-model="product.assignedSegments[c]" name="SegmentProductSale[@{{ k }}_@{{c}}][quantity]" ng-change="getProductsWithoutSegments(product)" />
              <input type="hidden" ng-if="!product.pack_id && !product.isPack" ng-model="segment.pivot.id" ng-value="segment.pivot.id" name="SegmentProductSale[@{{ k }}_@{{c}}][segment_product]"  />

              <!--<select ng-if="!product.pack_id && !product.isPack" class="form-control" ng-model="product.assignedSegments[c]" name="SegmentProductSale[@{{segment.pivot.id}}][quantity]" ng-change="getProductsWithoutSegments(product)" >

                <option ng-repeat="n in [] | range:getMaxProductSegment(getProductsWithoutSegments(product) , segment.pivot.quantity , product.assignedSegments[c])" value="@{{ n+1 }}">@{{ n+1 }}</option>
              </select>-->
                  <input type="hidden" ng-if="product.pack_id && !product.isPack" name="SegmentProductPackSale[@{{segment.pivot.id}}][pack_id]" value="@{{ product.pack_id }}">
              <input type="number" ng-if="product.pack_id && !product.isPack" class="form-control" ng-model="product.assignedSegments[c]" name="SegmentProductPackSale[@{{segment.pivot.id}}][quantity]" ng-change="getProductsWithoutSegments(product)" />

              <!--<select ng-if="product.pack_id && !product.isPack" class="form-control" ng-model="product.assignedSegments[c]" name="SegmentProductPackSale[@{{segment.pivot.id}}][quantity]" ng-change="getProductsWithoutSegments(product)" >

                      <option ng-repeat="n in [] | range:getMaxProductSegment(getProductsWithoutSegments(product) , segment.pivot.quantity , product.assignedSegments[c])" value="@{{ n+1 }}">@{{ n+1 }}</option>
                  </select>-->
          </td>
          <td></td>
          <td></td>
        </tr>


      </tbody>

      <tbody>

      	<tr ng-repeat="(k , pack) in packsSelected" >

  	    	<td> @{{pack.id }}</td>

  	      	<td> @{{pack.name }}</td>

  	      	<td> Paquete </td>

  	      	<td> @{{pack.key }}</td>

  		    <td> @{{pack.description }}</td>

  		    <td> </td>

  		    <td> @{{pack.price | currency }}</td>

  		    <td>

          		<div id="spinner1 col-sm-2">

                    <div class="input-group input-small">

                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="pack.quantity" name="PackSale[@{{ pack.id }}][quantity]" >

                        <div class="spinner-buttons input-group-btn btn-group-vertical">

                          <button ng-click= "pack.quantity = addQuantity(pack.quantity )" type="button" class="btn spinner-up btn-xs btn-default">

                              <i class="fa fa-angle-up"></i>

                            </button>

                            <button ng-click= "pack.quantity = removeQuantity(pack.quantity)" type="button" class="btn spinner-down btn-xs btn-default">

                              <i class="fa fa-angle-down"></i>

                            </button>

                        </div>

                    </div>

                  </div>

        		</td>

        		<td> @{{ pricePerQuantity(pack.price , pack.quantity) | currency  }}</td>

        		<td>

  		    	<button type="button" class="col-sm-12 btn btn-danger" ng-click="removePack(k)" >

  		          <i class="fa fa-times"></i>

  		        </button>

  		    </td>

      	</tr>

      	<tr>

  	    	<td colspan="6"></td>

  	      	<td colspan="2" class="text-right">

  	        	<b>Total de venta</b>

  	      	</td>

        		<td colspan="2">

          		@{{ getTotalPrice() | currency }}

        		</td>

      	</tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Costo de la entrega</b>

            </td>

            <td colspan="2">

              @{{ getDeliveryCost() | currency }}

            </td>

        </tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Comisión por foma de pago (@{{ percent_commission }}%)</b>

            </td>

            <td colspan="2">

              @{{ getCommissionPay() | currency }}

            </td>

        </tr>

        <tr>

          <td colspan="6"></td>

            <td colspan="2" class="text-right">

              <b>Total</b>

            </td>

            <td colspan="2">

              @{{ getFinalPrice() | currency }}

            </td>

        </tr>

      </tbody>

  </table>

</div>
