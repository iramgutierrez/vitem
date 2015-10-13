<div class="col-sm-12" ng-init="
@if(Input::old('ProductDevolution'))
  @foreach(Input::old('ProductDevolution') as $k => $p)
            productsOld.push({
              product_id : '{{ $k }}',
              quantity : '{{ $p['quantity'] }}',
              status : '{{ $p['status'] }}'
            });
  @endforeach
        getProductsOld();
@elseif(!empty($devolution))
  getProductsSelected({{ $devolution->id }} );
@endif  " >

    <table class="table table-bordered table-striped table-condensed" >

        <thead>

        <tr>

            <th>Nombre</th>

            <th>Código</th>

            <th>Proveedor</th>

            <th>Modelo / Descripción</th>

            <th>En existencia</th>

            <th>Costo unitario</th>

            <th>Status</th>

            <th class="col-sm-2">Cantidad</th>

            <th>Costo</th>

            <th>Borrar</th>

        </tr>

        </thead>

        <tbody>

        <tr ng-repeat="(k , product) in $root.productsSelected">


            <td> @{{product.name }}</td>

            <td> @{{product.key }}</td>

            <td> @{{product.supplier.name }}</td>

            <td> @{{product.model }}</td>

            <td> @{{product.stock }}</td>

            <td> @{{product.cost | currency }}</td>

            <td>

                <select name="ProductDevolution[@{{ product.id }}][status]" class="form-control" >
                    @foreach($statuses as $k => $status)

                        <option ng-selected="product.pivot.status == {{ $k }}" value="{{ $k }}"> {{ $status }}</option>

                    @endforeach
                </select>

            </td>

            <td>

                <div id="spinner1 col-sm-2">

                    <div class="input-group input-small">

                        <input type="text" class="spinner-input form-control" maxlength="3" ng-model="product.quantity" ng-init="product.quantity = quantityInit(product)" name="ProductDevolution[@{{ product.id }}][quantity]" >

                        <div class="spinner-buttons input-group-btn btn-group-vertical">

                            <button ng-click= "product.quantity = addQuantity(product.quantity)" type="button" class="btn spinner-up btn-xs btn-default">

                                <i class="fa fa-angle-up"></i>

                            </button>

                            <button ng-click= "product.quantity = removeQuantity(product.quantity)" type="button" class="btn spinner-down btn-xs btn-default">

                                <i class="fa fa-angle-down"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </td>

            <td> @{{ costPerQuantity(product.cost , product.quantity) | currency  }}</td>

            <td>

                <button type="button" class="col-sm-12 btn btn-danger" ng-click="removeProduct(k)" >

                    <i class="fa fa-times"></i>

                </button>

            </td>

        </tr>

        <tr>

            <td colspan="5"></td>

            <td colspan="2" class="text-right">

                <b>Total de pedido</b>

            </td>

            <td colspan="2">

                @{{ getTotalCost() | currency }}

            </td>

        </tr>

        </tbody>

    </table>

</div>
